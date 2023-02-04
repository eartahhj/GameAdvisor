<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->view('admin/users/index', compact('users'));
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('admin.users.create', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function store(Request $request, User $user)
    {
        // Rule::unique('reviews', 'text')
        $formFields = $request->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|min:8|unique:users,email',
            'is_admin' => '',
            'is_superadmin' => ''
        ]);

        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['email_verified_at'] = now();

        if ($newUser = User::create($formFields)) {
            return redirect(route('admin.users.edit', $newUser))->with('confirm', _('User created'));
        } else {
            return redirect(route('admin.users.create'))->with('error', _('Error creating user'));
        }

    }

    public function edit(User $user)
    {
        if (!$user) {
            abort(404);
        }

        if (!auth()->user()->is_superadmin) {
            abort(401);
        }

        return view('admin/users/edit', compact('user'));
    }

    public function editUserGroups(int $userId)
    {
        $user = $this->users->find($userId);

        if (!$user) {
            abort(401);
        }

        if (!auth()->user()->is_superadmin) {
            abort(401);
        }

        $groups = $this->request->getPost('groups');
        
        if (!$user->syncGroups(...$groups)) {
            return redirect()->back()->with('error', _('There was an error updating the groups'))->withInput();
        } else {
            return redirect()->back()->with('success', _('Groups updated!'));
        }
    }

    public function editUserPermissions(int $userId)
    {
        $user = $this->users->find($userId);

        if (!$user) {
            abort(401);
        }

        if (!auth()->user()->is_superadmin) {
            abort(401);
        }

        $permissions = $this->request->getPost('permissions');
        
        if (!$user->syncPermissions(...$permissions)) {
            return redirect()->back()->with('error', _('There was an error updating the permissions'))->withInput();
        } else {
            return redirect()->back()->with('success', _('Permissions updated!'));
        }
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
