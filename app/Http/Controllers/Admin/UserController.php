<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function index() {
        $users = User::withCount(['orders','prescriptions'])
            ->orderBy('created_at','desc')
            ->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user) {
        $request->validate(['role' => 'required|in:customer,pharmacist,admin']);

        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', app()->getLocale()==='ar'
                ? 'لا يمكنك تغيير دورك الخاص'
                : 'You cannot change your own role');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', app()->getLocale()==='ar'
            ? 'تم تغيير الدور بنجاح'
            : 'Role updated successfully');
    }
}
