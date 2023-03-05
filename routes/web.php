<?php
use App\Models\Review;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\DataRequestController;
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
        )->name('index');

        ### --- REGISTRATION --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.users.register'),
            [UserController::class, 'registrationForm']
        )->name('users.register.form');

        Route::post(
            LaravelLocalization::transRoute('routes.users.register'),
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
            [UserController::class, 'resetPasswordForm']
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

        ### --- USER --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.users.show.{user}'),
            [UserController::class, 'show']
        )->name('users.show');

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
            [UserController::class, 'myReviews']
        )->middleware(['auth', 'verified'])->name('user.myReviews');

        Route::put(
            LaravelLocalization::transRoute('routes.user.update'),
            [UserController::class, 'update']
        )->middleware(['auth', 'verified'])->name('user.update');

        Route::get(
            LaravelLocalization::transRoute('routes.user.changePassword'),
            [UserController::class, 'changePasswordView']
        )->middleware(['auth', 'verified'])->name('user.changePasswordView');

        Route::put(
            LaravelLocalization::transRoute('routes.user.changePassword'),
            [UserController::class, 'changePasswordAction']
        )->middleware(['auth', 'verified'])->name('user.changePasswordAction');

        Route::delete(
            LaravelLocalization::transRoute('routes.user.deleteMyAccount'),
            [UserController::class, 'deleteMyAccount']
        )->middleware(['auth', 'verified'])->name('user.deleteMyAccount');

        Route::delete(
            LaravelLocalization::transRoute('routes.user.delete'),
            [UserController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('user.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.user.review.{review}.edit'),
            [UserController::class, 'editReview']
        )->middleware(['auth', 'verified'])->name('user.review.edit');

        Route::put(
            LaravelLocalization::transRoute('routes.user.review.{review}'),
            [UserController::class, 'updateReview']
        )->middleware(['auth', 'verified'])->name('user.review.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.user.review.{review}'),
            [UserController::class, 'deleteReview']
        )->middleware(['auth', 'verified'])->name('user.review.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.user.review.{review}'),
            [ReviewController::class, 'show']
        )->middleware(['auth', 'verified'])->name('user.review');

        ### --- REVIEWS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.reviews'),
            [ReviewController::class, 'index']
        )->name('reviews.index');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.create.{game}'),
            [ReviewController::class, 'create']
        )->name('reviews.create');

        Route::post(
            LaravelLocalization::transRoute('routes.reviews.store.{game}'),
            [ReviewController::class, 'store']
        )->name('reviews.store');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.{review}.edit'),
            [ReviewController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('reviews.edit');

        Route::put(
            LaravelLocalization::transRoute('routes.reviews.{review}'),
            [ReviewController::class, 'update']
        )->middleware(['auth', 'admin'])->name('reviews.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.reviews.{review}'),
            [ReviewController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('reviews.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.{review}'),
            [ReviewController::class, 'show']
        )->name('reviews.show');

        Route::put(
            LaravelLocalization::transRoute('routes.reviews.{review}.approve'),
            [ReviewController::class, 'approve']
        )->middleware(['auth', 'admin'])->name('reviews.approve');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.game.{game}'),
            [ReviewController::class, 'showReviewsByGame']
        )->name('reviews.game');

        Route::get(
            LaravelLocalization::transRoute('routes.reviews.choose.game'),
            [ReviewController::class, 'chooseGame']
        )->name('reviews.choose.game');

        ### --- GAMES --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.games'),
            [GameController::class, 'index']
        )->name('games.index');

        Route::get(
            LaravelLocalization::transRoute('routes.games.create'),
            [GameController::class, 'create']
        )->middleware(['auth', 'admin'])->name('games.create');

        Route::post(
            LaravelLocalization::transRoute('routes.games.store'),
            [GameController::class, 'store']
        )->middleware(['auth', 'admin'])->name('games.store');

        Route::put(
            LaravelLocalization::transRoute('routes.games.{game}'),
            [GameController::class, 'update']
        )->middleware(['auth', 'admin'])->name('games.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.games.{game}'),
            [GameController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('games.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.games.{game}.edit'),
            [GameController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('games.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.games.{game}'),
            [GameController::class, 'show']
        )->name('games.show');
        
        ### --- PLATFORMS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.platforms'),
            [PlatformController::class, 'index']
        )->name('platforms.index');

        Route::get(
            LaravelLocalization::transRoute('routes.platforms.create'),
            [PlatformController::class, 'create']
        )->middleware(['auth', 'admin'])->name('platforms.create');

        Route::post(
            LaravelLocalization::transRoute('routes.platforms.store'),
            [PlatformController::class, 'store']
        )->middleware(['auth', 'admin'])->name('platforms.store');

        Route::put(
            LaravelLocalization::transRoute('routes.platforms.{platform}'),
            [PlatformController::class, 'update']
        )->middleware(['auth', 'admin'])->name('platforms.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.platforms.{platform}'),
            [PlatformController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('platforms.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.platforms.{platform}.edit'),
            [PlatformController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('platforms.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.platforms.{platform}'),
            [PlatformController::class, 'show']
        )->name('platforms.show');

        ### --- DEVELOPERS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.developers'),
            [DeveloperController::class, 'index']
        )->name('developers.index');

        Route::get(
            LaravelLocalization::transRoute('routes.developers.create'),
            [DeveloperController::class, 'create']
        )->middleware(['auth', 'admin'])->name('developers.create');

        Route::post(
            LaravelLocalization::transRoute('routes.developers.store'),
            [DeveloperController::class, 'store']
        )->middleware(['auth', 'admin'])->name('developers.store');

        Route::put(
            LaravelLocalization::transRoute('routes.developers.{developer}'),
            [DeveloperController::class, 'update']
        )->middleware(['auth', 'admin'])->name('developers.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.developers.{developer}'),
            [DeveloperController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('developers.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.developers.{developer}.edit'),
            [DeveloperController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('developers.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.developers.{developer}'),
            [DeveloperController::class, 'show']
        )->name('developers.show');

        ### --- GAME PUBLISHERS --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.publishers'),
            [PublisherController::class, 'index']
        )->name('publishers.index');

        Route::get(
            LaravelLocalization::transRoute('routes.publishers.create'),
            [PublisherController::class, 'create']
        )->middleware(['auth', 'admin'])->name('publishers.create');

        Route::post(
            LaravelLocalization::transRoute('routes.publishers.store'),
            [PublisherController::class, 'store']
        )->middleware(['auth', 'admin'])->name('publishers.store');

        Route::put(
            LaravelLocalization::transRoute('routes.publishers.{publisher}'),
            [PublisherController::class, 'update']
        )->middleware(['auth', 'admin'])->name('publishers.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.publishers.{publisher}'),
            [PublisherController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('publishers.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.publishers.{publisher}.edit'),
            [PublisherController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('publishers.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.publishers.{publisher}'),
            [PublisherController::class, 'show']
        )->name('publishers.show');

        ### --- PAGES --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.pages.create'),
            [PageController::class, 'create']
        )->middleware(['auth', 'admin'])->name('pages.create');

        Route::post(
            LaravelLocalization::transRoute('routes.pages.store'),
            [PageController::class, 'store']
        )->middleware(['auth', 'admin'])->name('pages.store');

        Route::put(
            LaravelLocalization::transRoute('routes.pages.{page}.publish'),
            [PageController::class, 'publish']
        )->middleware(['auth', 'admin'])->name('pages.publish');
        
        Route::put(
            LaravelLocalization::transRoute('routes.pages.{page}'),
            [PageController::class, 'update']
        )->middleware(['auth', 'admin'])->name('pages.update');

        Route::delete(
            LaravelLocalization::transRoute('routes.pages.{page}'),
            [PageController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('pages.delete');

        Route::get(
            LaravelLocalization::transRoute('routes.pages.{page}.edit'),
            [PageController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('pages.edit');

        Route::get(
            LaravelLocalization::transRoute('routes.pages.{page}'),
            [PageController::class, 'show']
        )->name('pages.show');

        ### --- ADMIN --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.admin.index'),
            [AdminController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.index');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.games.index'),
            [GameController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.games.index');
        
        Route::get(
            LaravelLocalization::transRoute('routes.admin.platforms.index'),
            [PlatformController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.platforms.index');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.publishers.index'),
            [PublisherController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.publishers.index');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.developers.index'),
            [DeveloperController::class, 'index']
        )->middleware(['auth', 'admin'])->name('admin.developers.index');

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
        )->middleware(['auth', 'admin'])->name('admin.users.update');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.users.{user}.edit'),
            [AdminUserController::class, 'edit']
        )->middleware(['auth', 'admin'])->name('admin.users.edit');

        Route::post(
            LaravelLocalization::transRoute('routes.admin.users.store'),
            [AdminUserController::class, 'store']
        )->middleware(['auth', 'admin'])->name('admin.users.store');

        Route::get(
            LaravelLocalization::transRoute('routes.admin.users.{user}'),
            [AdminUserController::class, 'destroy']
        )->middleware(['auth', 'admin'])->name('admin.users.show');

        ### --- REQUEST DATA --- ###
        Route::get(
            LaravelLocalization::transRoute('routes.datarequests.create'),
            [DataRequestController::class, 'create']
        )->name('datarequests.create');

        Route::post(
            LaravelLocalization::transRoute('routes.datarequests.store'),
            [DataRequestController::class, 'store']
        )->name('datarequests.store');
    }
);