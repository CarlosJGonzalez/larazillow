<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;

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

Route::resource( 'user-account', UserAccountController::class )->only(['create', 'store']);

Route::delete('login', [AuthController::class,'create']);

Route::prefix( 'realtor' )
    ->name('realtor.')
    ->middleware('auth')
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