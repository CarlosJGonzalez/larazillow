<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use Inertia\Inertia;

Route::get('/', [IndexController::class, 'index'])
    ->name('home');
Route::get('/hello', [IndexController::class, 'show'])
    ->middleware('auth');

Route::resource( 'listing', ListingController::class )
    ->only(['index','show']);

Route::resource( 'listing.offer', ListingOfferController::class)
    ->middleware('auth')
    ->only(['store']);

Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only(['index', 'update']);

Route::get( 'login', [AuthController::class, 'create'])
    ->name('login');
Route::post( 'login', [AuthController::class, 'store'])
    ->name('login.store');
Route::delete( 'logout', [AuthController::class, 'destroy'])
    ->name( 'logout');

Route::get('/email/verify', function () {
    $user = Auth::user();
    $url = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    return inertia::render('Auth/VerifyEmail',['url' => $url]);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function( EmailVerificationRequest $request ){
    $request->fulfill();
    return redirect('/realtor/listing');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post( '/email/verification-notification', function( Request $request ){
    $request->user()->sendEmailVerificationNotification();

    return back()->with( 'success', 'Verification link sent!' );
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::resource( 'user-account', UserAccountController::class )->only(['create', 'store']);

Route::delete('login', [AuthController::class,'create']);

Route::prefix( 'realtor' )
    ->name('realtor.')
    ->middleware(['auth', 'verified'])
    ->group( function() {
        Route::name('listing.restore')
            ->put(
                'listing/{listing}/restore',
                [RealtorListingController::class, 'restore']
            )->withTrashed();

        Route::name('offer.accept')->put('offer/{offer}/accept', RealtorListingAcceptOfferController::class );

        Route::resource('listing', RealtorListingController::class)
            //->only(['index', 'destroy', 'edit', 'update', 'create', 'store', 'show'])
            ->withTrashed();

        Route::resource( 'listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
    });
;

Route::get('/realtor/listing/images/library', [RealtorListingImageController::class, 'library'])
    ->name('realtor.listing.image.library');