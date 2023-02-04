<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\EmailVerificationNotification;
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
        return view('users.create');
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
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registrationForm()
    {
        self::$templateStylesheets[] = '/css/forms.css';
        
        return view('users.register', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function register(Request $request)
    {
        // dd($user = self::store($request));
        if ($user = self::store($request)) {
            auth()->login($user);

            // return redirect(route('users.register.form'))->with('confirm', _('Registration successfull! You can now login at: ') . '<a href="' . route('users.login') . '">' . _('Login') . '</a>');

            # Send verification email
            event(new Registered($user));
            self::sendVerificationEmailToNewUser($user);

            return redirect(route('users.register.form'))->with('confirm', _('Registration successfull! You will receive an email to activate your account!'));
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

        return view('users.login-form', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
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

        return view('users.forgottenpassword-form', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function forgottenPasswordSendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return back()->with(['confirm' => _('If an account is associated to the e-mail address provided, you will receive instructions on how to reset your password.')]);
    }

    public static function resetPasswordForm($token)
    {
        self::$templateStylesheets[] = '/css/forms.css';

        return view('users.resetpassword-form', ['token' => $token, 'templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
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

        return view('users.dashboard', ['templateStylesheets' => static::$templateStylesheets, 'templateJavascripts' => static::$templateJavascripts]);
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function reviews()
    {
        self::$templateStylesheets[] = '/css/reviews.css';

        return view('user.reviews', [
            'reviews' => Review::join('games', 'reviews.game_id', '=', 'games.id')
            ->select('reviews.*', 'games.title AS game_title')
            ->where('reviews.user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20),
            'templateStylesheets' => static::$templateStylesheets,
            'templateJavascripts' => static::$templateJavascripts
        ]);
    }

    public function sendVerificationEmailToNewUser(User $user)
    {
        // $url = route('verification.verify');
        // $user->notify(new EmailVerificationNotification($url));
        // $user->notify(new VerifyEmail);
    }
}
