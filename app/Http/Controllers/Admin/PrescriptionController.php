<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller {


    public function index() {
        $prescriptions = Prescription::with('user')->latest()->paginate(20);
        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function review(Request $request, Prescription $prescription) {
        $request->validate([
            'status'            => 'required|in:approved,rejected',
            'pharmacist_notes'  => 'nullable|string|max:500',
        ]);
        $prescription->update([
            'status'           => $request->status,
            'pharmacist_notes' => $request->pharmacist_notes,
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
        ]);
        return back()->with('success','Prescription reviewed');
    }
}
