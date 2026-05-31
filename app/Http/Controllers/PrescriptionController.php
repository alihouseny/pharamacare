<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller {


    public function index() {
        $prescriptions = auth()->user()->prescriptions()->latest()->paginate(10);
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create() {
        return view('prescriptions.create');
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|image|max:5120',
            'notes' => 'nullable|string|max:500',
        ]);

        $path = $request->file('image')->store('prescriptions', 'public');

        Prescription::create([
            'user_id' => auth()->id(),
            'image'   => $path,
            'notes'   => $request->notes,
        ]);

        return redirect()->route('prescriptions.index')
            ->with('success', app()->getLocale() === 'ar' ? 'تم رفع الروشيتة بنجاح، سيتم مراجعتها قريباً' : 'Prescription uploaded, will be reviewed soon');
    }
}
