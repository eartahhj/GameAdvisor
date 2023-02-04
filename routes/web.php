<?php
use App\Models\Review;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GamesPlatformController;
use App\Http\Controllers\GamesDeveloperController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get(
//     '/en/reviews/create',
//     [\App\Http\Controllers\ReviewController::class, 'create']
// )->name('reviews.create');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function()
    {
        // Route::get('/', function() {
        //     return view('index', ['latestReviews'=>[]]);
        // })->name('index');

        // Route::get(LaravelLocalization::transRoute('/'), function () {
        //     return view('index', [
        //         'latestReviews' => \App\Models\Review::latest()->get()
        //     ]);
        // })->name('index');

        ### --- HOMEPAGE --- ###
        Route::get(
            LaravelLocalization::transRoute('/'),
            [IndexController::class, 'index']
        )->middleware('auth')->name('index');

        ### --- REGISTRATION --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.users.register.register'),
            [UserController::class, 'registrationForm']
        )->name('users.register.form');

        Route::post(
            LaravelLocalization::transRoute('routes.users.register.form'),
            [UserController::class, 'register']
        )->name('users.register.register');

        ### --- EMAIL VERIFICATION --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.users.email.verification.notice'),
            [VerifyEmailController::class, 'index']
        )->middleware('auth')->name('verification.notice');

        Route::get(
            LaravelLocalization::transRoute('routes.users.email.verification.verify.{id}.{hash}'),
            function (EmailVerificationRequest $request) {
                $request->fulfill();
                return redirect(route('users.dashboard'))->with('confirm', _('Thank you! Your e-mail address has been verified!'));
        })->middleware(['auth', 'signed'])->name('verification.verify');

        Route::post(
            LaravelLocalization::transRoute('routes.users.email.verification.resend'),
            function (Request $request) {
                auth()->user()->sendEmailVerificationNotification();
                return back()->with('message', _('Verification link sent!'));
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

        ### --- LOGIN --- ###
        Route::post(
            LaravelLocalization::transRoute('routes.users.login.auth'),
            [UserController::class, 'login']
        )->name('users.login.auth');

        Route::get(
            LaravelLocalization::transRoute('routes.users.login.form'),
            [UserController::class, 'loginForm']
        )->name('users.login.form');

        ### --- RESET PASSWORD --- ###
        Route::post(
            LaravelLocalization::transRoute('routes.users.forgottenpassword'),
            [UserController::class, 'forgottenPasswordSendEmail']
        )->middleware('guest')->name('users.forgottenpassword');

        Route::get(
            LaravelLocalization::transRoute('routes.users.forgottenpassword.form'),
            [UserController::class, 'forgottenPasswordForm']
        )->middleware('guest')->name('users.forgottenpassword.form');

        Route::get(
            LaravelLocalization::transRoute('routes.users.resetpassword'),
            function() {
                return redirect(route('users.forgottenpassword.form'));
            }
        )->middleware('guest')->name('users.resetpassword.form');

        Route::get(
            LaravelLocalization::transRoute('routes.users.resetpassword.{token}'),
            [UserController::class, 'resetPasswordForm']
        )->middleware('guest')->name('password.reset');

        Route::post(
            LaravelLocalization::transRoute('routes.users.resetpassword'),
            [UserController::class, 'resetPassword']
        )->middleware('guest')->name('users.resetpassword');

        ### --- LOGOUT --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.users.logout'),
            [UserController::class, 'logout']
        )->name('users.logout');

        ### --- USER --- #
        Route::get(
            LaravelLocalization::transRoute('routes.users.dashboard'),
            [UserController::class, 'dashboard']
        )->middleware('auth')->name('users.dashboard');

        Route::get(
            LaravelLocalization::transRoute('routes.user.profile'),
            [UserController::class, 'profile']
        )->middleware(['auth', 'verified'])->name('user.profile');

        Route::get(
            LaravelLocalization::transRoute('routes.user.myReviews'),
            [UserController::class, 'reviews']
        )->middleware(['auth', 'verified'])->name('user.myReviews');

        ### --- REVIEWS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.reviews'),
            [ReviewController::class, 'index']
        )->middleware('auth')->name('reviews.index');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.create.{game}'),
            [ReviewController::class, 'create']
        )->middleware('auth')->name('reviews.create');

        Route::post(
            LaravelLocalization::transRoute('routes.reviews.store.{game}'),
            [ReviewController::class, 'store']
        )->middleware('auth')->name('reviews.store');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.{review}.edit'),
            [ReviewController::class, 'edit']
        )->middleware('auth')->name('reviews.edit');

        Route::put(
            LaravelLocalization::transRoute('routes.reviews.{review}'),
            [ReviewController::class, 'update']
        )->middleware('auth')->name('reviews.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.reviews.{review}'),
            [ReviewController::class, 'destroy']
        )->middleware('auth')->name('reviews.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.game.{game}'),
            [ReviewController::class, 'showReviewsByGame']
        )->middleware('auth')->name('reviews.game');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.choose.game'),
            [ReviewController::class, 'chooseGame']
        )->middleware('auth')->name('reviews.choose.game');

        ### --- GAMES --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.games'),
            [GameController::class, 'index']
        )->middleware('auth')->name('games.index');

        Route::get(
            LaravelLocalization::transRoute('routes.games.create'),
            [GameController::class, 'create']
        )->middleware('auth')->name('games.create');

        Route::post(
            LaravelLocalization::transRoute('routes.games.store'),
            [GameController::class, 'store']
        )->middleware('auth')->name('games.store');

        Route::put(
            LaravelLocalization::transRoute('routes.games.{game}'),
            [GameController::class, 'update']
        )->middleware('auth')->name('games.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.games.{game}'),
            [GameController::class, 'destroy']
        )->middleware('auth')->name('games.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.games.{game}.edit'),
            [GameController::class, 'edit']
        )->middleware('auth')->name('games.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.games.{game}'),
            [GameController::class, 'show']
        )->middleware('auth')->name('games.show');
        
        ### --- GAME PLATFORMS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.platforms'),
            [GamesPlatformController::class, 'index']
        )->middleware('auth')->name('platforms.index');

        Route::get(
            LaravelLocalization::transRoute('routes.platforms.create'),
            [GamesPlatformController::class, 'create']
        )->middleware('auth')->name('platforms.create');

        Route::post(
            LaravelLocalization::transRoute('routes.platforms.store'),
            [GamesPlatformController::class, 'store']
        )->middleware('auth')->name('platforms.store');

        Route::put(
            LaravelLocalization::transRoute('routes.platforms.{platform}'),
            [GamesPlatformController::class, 'update']
        )->middleware('auth')->name('platforms.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.platforms.{platform}'),
            [GamesPlatformController::class, 'destroy']
        )->middleware('auth')->name('platforms.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.platforms.{platform}.edit'),
            [GamesPlatformController::class, 'edit']
        )->middleware('auth')->name('platforms.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.platforms.{platform}'),
            [GamesPlatformController::class, 'show']
        )->middleware('auth')->name('platforms.show');

        ### --- GAME DEVELOPERS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.developers'),
            [GamesDeveloperController::class, 'index']
        )->middleware('auth')->name('developers.index');

        Route::get(
            LaravelLocalization::transRoute('routes.developers.create'),
            [GamesDeveloperController::class, 'create']
        )->middleware('auth')->name('developers.create');

        Route::post(
            LaravelLocalization::transRoute('routes.developers.store'),
            [GamesDeveloperController::class, 'store']
        )->middleware('auth')->name('developers.store');

        Route::put(
            LaravelLocalization::transRoute('routes.developers.{developer}'),
            [GamesDeveloperController::class, 'update']
        )->middleware('auth')->name('developers.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.developers.{developer}'),
            [GamesDeveloperController::class, 'destroy']
        )->middleware('auth')->name('developers.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.developers.{developer}.edit'),
            [GamesDeveloperController::class, 'edit']
        )->middleware('auth')->name('developers.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.developers.{developer}'),
            [GamesDeveloperController::class, 'show']
        )->middleware('auth')->name('developers.show');

        ### --- GAME PUBLISHERS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.publishers'),
            [PublisherController::class, 'index']
        )->middleware('auth')->name('publishers.index');

        Route::get(
            LaravelLocalization::transRoute('routes.publishers.create'),
            [PublisherController::class, 'create']
        )->middleware('auth')->name('publishers.create');

        Route::post(
            LaravelLocalization::transRoute('routes.publishers.store'),
            [PublisherController::class, 'store']
        )->middleware('auth')->name('publishers.store');

        Route::put(
            LaravelLocalization::transRoute('routes.publishers.{publisher}'),
            [PublisherController::class, 'update']
        )->middleware('auth')->name('publishers.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.publishers.{publisher}'),
            [PublisherController::class, 'destroy']
        )->middleware('auth')->name('publishers.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.publishers.{publisher}.edit'),
            [PublisherController::class, 'edit']
        )->middleware('auth')->name('publishers.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.publishers.{publisher}'),
            [PublisherController::class, 'show']
        )->middleware('auth')->name('publishers.show');

        ### --- PAGES --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.pages.create'),
            [PageController::class, 'create']
        )->middleware('auth')->name('pages.create');

        Route::post(
            LaravelLocalization::transRoute('routes.pages.store'),
            [PageController::class, 'store']
        )->middleware('auth')->name('pages.store');

        Route::put(
            LaravelLocalization::transRoute('routes.pages.{page}.publish'),
            [PageController::class, 'publish']
        )->middleware('auth')->name('pages.publish');
        
        Route::put(
            LaravelLocalization::transRoute('routes.pages.{page}'),
            [PageController::class, 'update']
        )->middleware('auth')->name('pages.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.pages.{page}'),
            [PageController::class, 'destroy']
        )->middleware('auth')->name('pages.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.pages.{page}.edit'),
            [PageController::class, 'edit']
        )->middleware('auth')->name('pages.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.pages.{page}'),
            [PageController::class, 'show']
        )->middleware('auth')->name('pages.show');

        ### --- ADMIN --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.admin.index'),
            [AdminController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.index');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.pages.index'),
            [AdminPageController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.pages.index');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.users.index'),
            [AdminUserController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.users.index');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.users.create'),
            [AdminUserController::class, 'create']
        )->middleware(['auth', 'admin'])->name('admin.users.create');

        Route::delete(
            LaravelLocalization::transRoute('routes.admin.users.{user}'),
            [AdminUserController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('admin.users.delete');

        Route::put(
            LaravelLocalization::transRoute('routes.admin.users.{user}'),
            [AdminUserController::class, 'update']
        )->middleware('auth')->name('admin.users.update');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.users.{user}.edit'),
            [AdminUserController::class, 'edit']
        )->middleware('auth')->name('admin.users.edit');

        Route::post(
            LaravelLocalization::transRoute('routes.admin.users.store'),
            [AdminUserController::class, 'store']
        )->middleware('auth')->name('admin.users.store');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.users.{user}'),
            [AdminUserController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('admin.users.show');
    }
);