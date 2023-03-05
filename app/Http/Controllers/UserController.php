<?php

namespace App\Http\Controllers;

use App\Models\User;
use RuntimeException;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Mail\UserRegisteredNotificationToAdmin;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Validation\Rules\Password as PasswordRules;
// use Illuminate\Auth\Notifications\VerifyEmail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['pageTitle' => _('New user')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): ?User
    {
        $formFields = $request->validate([
            'name' => '',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        if (!$user = User::create($formFields)) {
            return null;
        } else {
            return $user;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->private_profile) {
            abort(404);
        }

        $reviews = null;

        $numberOfReviews = Review::where('user_id', $user->id)->count('user_id') or 0;

        if (!$user->private_profile) {
            $reviews = Review::where('user_id', $user->id)->paginate(2);
        }

        self::$templateStylesheets[] = '/css/reviews.css';
        self::$templateStylesheets[] = '/css/users.css';

        return view('users.show', [
            'user' => $user,
            'pageTitle' => sprintf(_('User: %s'), $user->name),
            'reviews' => $reviews,
            'numberOfReviews' => $numberOfReviews,
            'templateStylesheets' => self::$templateStylesheets,
            'templateJavascripts' => self::$templateJavascripts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $email = $request->input('email');
        
        $validationRules = [
            'bio' => 'max:1000',
            'private_profile' => 'boolean'
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

            if (auth()->user()->sendEmailVerificationNotification()) {
                redirect(route('verification.notice'))->with('warning', _('There was an error sending the activation email. Your email address has been changed anyway. You can request a new verification email below.'))->withInput();
            }

            $user->email_verified_at = null;
        }
        
        $user->bio = $formFields['bio'];

        if (isset($formFields['private_profile'])) {
            $user->private_profile = true;
        } else {
            $user->private_profile = false;
        }

        $user->save();

        if ($user->wasChanged('email')) {
            return redirect(route('verification.notice'))->with('info', _('Please check your email to activate it.'));
        } else {
            return back()->with('confirm', _('Profile info updated successfully.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($user = User::find($id)) {

            $reviews = Review::where('user_id', $user->id)->find();

            if (!$reviews->isEmpty()) {
                foreach ($reviews as $review) {
                    $reviewsIds[$review->id] = $review->id;
                }

                $reviews->update(['user_id', null]);
        
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
                return back()->with('success', sprintf(_('User #%s has been deleted succesfully'), $id));
            }
        }
    }

    public function registrationForm()
    {
        self::$templateStylesheets[] = '/css/forms.css';
        
        return view('users.register', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts, 'pageTitle' => _('Create an account')]);
    }

    public function register(Request $request)
    {
        if ($user = self::store($request)) {
            auth()->login($user);

            # Send verification email
            event(new Registered($user));

            $emailToAdmin = new UserRegisteredNotificationToAdmin($user);

            Mail::to(env('APP_EMAIL_ADMIN'))->send($emailToAdmin);

            return redirect(route('users.register.form'))->with('confirm', _('Registration successful! You will receive an email to activate your account!'));
        } else {
            return redirect(route('users.register.form'))->with('error', _('Error upon registration'));
        }
    }

    public function logout(Request $request)
    {
        if (auth()->user()) {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect(route('users.login.form'))->with('confirm', _('Logged out successfully'));
        } else {
            return redirect(route('users.login.form'), 302);
        }
    }

    public function loginForm()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('users.login-form', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts, 'pageTitle' => _('Login')]);
    }

    public function login(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect(route('users.dashboard'))->with('confirm', _('Logged in successfully'));
        }

        return back()->withErrors(['email' => _('Invalid credentials')])->onlyInput('email');
    }

    public function forgottenPasswordForm()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('users.forgottenpassword-form', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts, 'pageTitle' =>  _('Reset password')]);
    }

    public function forgottenPasswordSendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return back()->with(['confirm' => _('If an account is associated to the e-mail address provided, you will receive instructions on how to reset your password.')]);
    }

    public static function changePasswordView()
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('user.changePassword', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts, 'pageTitle' =>  _('Change your password')]);
    }

    public function changePasswordAction(Request $request)
    {
        $user = auth()->user();

        $data = $request->only(['password', 'password_confirm']);

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                PasswordRules::defaults()
            ]
        ]);

        $user->forceFill(['password' => Hash::make($request->password)]);
        $user->save();

        return redirect(route('user.profile'))->with('success', _('Password updated!'));
    }

    public static function resetPasswordForm($token)
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('users.resetpassword-form', ['token' => $token, 'templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts, 'pageTitle' =>  _('Change your password')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('users.login.form')->with('confirm', _('Your password has been updated.'))
                    : back()->withErrors(['email' => [_('Error resetting password.')]]);

    }

    // public function sendPasswordResetNotification($token)
    // {
    //     $url = route('password.reset', $token);
    //
    //     $this->notify(new ResetPasswordNotification($url));
    // }

    public function dashboard()
    {
        self::$templateStylesheets[] = '/css/dashboard.css';

        return view('users.dashboard', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts, 'pageTitle' => _('Dashboard')]);
    }

    public function profile()
    {
        return view('users.profile', [
            'pageTitle' => _('My profile'),
            'user' => auth()->user()
        ]);
    }

    public function myReviews()
    {
        self::$templateStylesheets[] = '/css/reviews.css';

        return view('user.myReviews', [
            'reviews' => Review::join('games', 'reviews.game_id', '=', 'games.id')
            ->select('reviews.*', 'games.title_' . getLanguage() . ' AS game_title')
            ->where([
                'reviews.user_id' => auth()->user()->id
            ])
            ->orderBy('created_at', 'DESC')
            ->paginate(20),
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => _('My reviews')
        ]);
    }

    public function showReviewsForUser(User $user)
    {
        self::$templateStylesheets[] = '/css/reviews.css';

        return view('user.reviews', [
            'reviews' => Review::join('games', 'reviews.game_id', '=', 'games.id')
            ->select('reviews.*', 'games.title_' . getLanguage() . ' AS game_title')
            ->where('reviews.user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(8),
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'pageTitle' => sprintf(_('Reviews posted by user: %s'), $user->name)
        ]);
    }

    public function sendVerificationEmailToNewUser(User $user)
    {
        // $url = route('verification.verify');
        // $user->notify(new EmailVerificationNotification($url));
        // $user->notify(new VerifyEmail);
    }

    public function deleteMyAccount()
    {
        $user = auth()->user();
        
        if ($user->id != auth()->user()) {
            abort(401);
        }

        if (!$this->destroy($user->id)) {
            return redirect(route('index'))->with('error', _('There was an error deleting your account!'));
        } else {
            return redirect(route('index'))->with('success', _('Your account has been deleted succesfully!'));

        }

    }

    public function deleteReview(Request $request, Review $review)
    {
        $reviewId = $request->only('review_id');

        if ($review->user_id != auth()->user()->id) {
            abort(401);
        }

        $imageToDelete = null;

        if ($review->image) {
            $imageToDelete = $review->image;
        }
        
        if (!$review->delete()) {
            return back()->with('error', _('There was an error deleting your review!'));
        } else {
            if ($imageToDelete) {
                Storage::delete($imageToDelete);
            }
            
            return redirect(route('user.myReviews'))->with('success', _('Your review has been deleted succesfully!'));
        }
    }

    public function editReview(Review $review)
    {
        if ($review->user_id != auth()->user()->id) {
            abort(401);
        }

        self::$templateStylesheets[] = '/css/forms.css';
        self::$templateStylesheets[] = '/css/rating-radiolist.css';
        self::$templateJavascripts[] = '/js/simpjs/simp.js';
        self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
        self::$templateStylesheets[] = '/js/simpjs/simp.css';

        $image = null;

        if (!empty($review->image)) {
            $image = \Image::make(\Storage::disk('public')->get($review->image));
        }

        return view('user.editReview', [
            'pageTitle' => _('Edit your review'),
            'review' => $review,
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts,
            'image' => $image,
            'supportedImageFormats' => Review::returnImageSupportedFormatsString()
        ]);
    }

    public function updateReview(Request $request, Review $review)
    {
        if ($review->user_id != auth()->user()->id) {
            abort(401);
        }

        $formFields = $request->validate([
            'title' => 'required',
            'text' => 'required',
            'rating' => 'required',
            'image' => Review::returnImageValidationString()
        ]);

        if ($request->hasFile('image') and auth()->user()->email_verified_at) {
            if ($review->image) {
                Storage::delete($review->image);
            }

            $image = $review->uploadImage();
            
            $formFields['image'] = $image;
        }

        $review->approved = false;

        if ($review->update($formFields)) {
            return redirect(route('user.review.edit', $review))->with('confirm', _('Review updated'));
        } else {
            return back()->with('error', _('Error updating the review'))->withInput();
        }
    }
}
