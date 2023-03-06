<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $pageTitle = _('Manage users');

        self::$templateStylesheets[] = '/css/panel.css';

        return response()->view('admin/users/index', [
            'users' => $users,
            'pageTitle' => $pageTitle,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }

    public function create()
    {
        self::$templateStylesheets[] = '/css/panel.css';
        self::$templateStylesheets[] = '/css/forms.css';

        return view('admin.users.create', [
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('Insert a new user')
        ]);
    }

    public function store(Request $request, User $user)
    {
        // Rule::unique('reviews', 'text')
        $formFields = $request->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|min:8|unique:users,email',
            'is_admin' => 'boolean',
            'is_superadmin' => 'boolean'
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

        $pageTitle = sprintf(_('Modifying user: %s'), $user->name);

        self::$templateStylesheets[] = '/css/panel.css';

        return view('admin/users/edit', [
            'user' => $user,
            'pageTitle' => $pageTitle,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }

    public function editUserGroups(int $userId)
    {
        // Taken from another project in CodeIgniter

        // $user = $this->users->find($userId);

        // if (!$user) {
        //     abort(401);
        // }

        // if (!auth()->user()->is_superadmin) {
        //     abort(401);
        // }

        // $groups = $this->request->getPost('groups');
        
        // if (!$user->syncGroups(...$groups)) {
        //     return redirect()->back()->with('error', _('There was an error updating the groups'))->withInput();
        // } else {
        //     return redirect()->back()->with('success', _('Groups updated!'));
        // }
    }

    public function editUserPermissions(int $userId)
    {
        // Taken from another project in CodeIgniter

        // $user = $this->users->find($userId);

        // if (!$user) {
        //     abort(401);
        // }

        // if (!auth()->user()->is_superadmin) {
        //     abort(401);
        // }

        // $permissions = $this->request->getPost('permissions');
        
        // if (!$user->syncPermissions(...$permissions)) {
        //     return redirect()->back()->with('error', _('There was an error updating the permissions'))->withInput();
        // } else {
        //     return redirect()->back()->with('success', _('Permissions updated!'));
        // }
    }

    public function update(User $user)
    {
        // TODO Test and improve, 2023-03-05

        $email = $request->input('email');
        
        $validationRules = [
            'bio' => 'max:1000',
            'is_admin' => 'boolean',
            'is_superadmin' => 'boolean'
        ];

        if ($email != $user->email) {
            $validationRules['email'] = ['email', Rule::unique('users', 'email')];
        }

        if (!$formFields = $request->validate($validationRules)
        ) {
            return back()->with('errors', $request->errors());
        }

        if (!empty($formFields['email']) and $formFields['email'] != $user->email) {
            $user->email = $formFields['email'];

            // Should we send verification email if this user is being changed by admin?
            // if ($user->sendEmailVerificationNotification()) {
            //     redirect(route('verification.notice'))->with('warning', _('There was an error sending the activation email. Your email address has been changed anyway. You can request a new verification email below.'))->withInput();
            // }

            // $user->email_verified_at = null;
        }
        
        $user->bio = $formFields['bio'];
        
        if (isset($formFields['is_admin'])) {
            $user->is_admin = true;
        } else {
            $user->is_admin = false;
        }

        if (isset($formFields['is_superadmin'])) {
            $user->is_superadmin = true;
        } else {
            $user->is_superadmin = false;
        }

        // $user->save();
    }

    public function destroy(User $user)
    {
        if (empty(auth()->user())) {
            abort(404);
        }

        if (!auth()->user()->is_superadmin) {
            abort(404);
        }

        $userId = $user->id;

        $reviews = Review::where('user_id', $user->id)->get();

        if (!$reviews->isEmpty()) {
            foreach ($reviews as $review) {
                $reviewsIds[$review->id] = $review->id;
            }

            $reviews->update(['user_id', null]);

            // From codeigniter, as a reference
            // $postsImages = $imageModel->whereIn('post_id', $postIds)->find();

            // if (!empty($postsImages)) {
                //     foreach ($postsImages as $image) {
                //         if (!is_file(WRITEPATH . 'uploads/' . $image->filename)) {
                //             continue;
                //         }

                //         unlink(WRITEPATH . 'uploads/' . $image->filename);
                //     }
            // }
        }

        if ($user->delete()) {
            return back()->with('success', sprintf(_('User #%s has been deleted succesfully'), $userId));
        }
    }
}
