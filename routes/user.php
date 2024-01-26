<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\HobbiesController;
use App\Http\Controllers\User\HomePageController;
use App\Http\Controllers\User\LocationController;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\FavouriteController;
use App\Http\Controllers\User\Auth\ProfileController;
use App\Http\Controllers\User\ProfileBasicController;
use App\Http\Controllers\User\FamilyDetailsController;
use App\Http\Controllers\User\ReligiousInformationController;
use App\Http\Controllers\User\ProfessionalInformationController;

Route::group(['namespace' => 'User', 'as' => 'user.'], function () {

    // Route::controller(AuthController::class)->group(function () {

    //     Route::get('signup', 'showUserSignupForm')->name('signup');
    //     Route::post('signup', 'userSignup')->name('signup.post');

    //     Route::get('signin', 'showUserLoginForm')->name('login');
    //     Route::post('generate-otp', 'generateUserOtp')->name('generate.otp');
    //     Route::get('verify', 'showUserVerifyForm')->name('verify');
    //     Route::post('user/signin', 'userLogin')->name('login.post');
    //     Route::get('forgot-password', 'showUserForgotPasswordForm')->name('forgot.password');
    // });

    // Route::middleware(['role:user'])->group(function () {

    //     Route::controller(AuthController::class)->group(function () {
    //         Route::get('logout', 'logout')->name('logout');
    //     });


    //     Route::controller(ProfileController::class)->group(function () {
    //         Route::get('my-profile', 'getProfile')->name('profile');
    //         Route::get('view-profile' , 'viewProfile')->name('view.profile');
    //     });


    //     // Route::get('top-matches', function () {
    //     //     return view('user.pages.top_matches');
    //     // })->name('top.matches');

    //     Route::controller(HomePageController::class)->group(function () {
    //         Route::get('top-matches', 'topMatches')->name('top.matches');
    //         // Route::get('top-matches', portalController::class)->name(
    //     });
    //     // Route::get('/', function () {
    //     //     return view('user.pages.auth.signup');
    //     //     // return view('user.pages.auth.signin');
    //     //     // return view('admin.pages.package.add');
    //     //     // return view('admin.pages.package.list');
    //     //     // return view('user.pages.homepage');
    //     // });

    //     Route::controller(ProfileBasicController::class)->group(function () {
    //         Route::get('profile-basic', 'showProfileForm')->name('profile.form');
    //         //  Route::get('religious' , 'showReligiousForm')->name('religious.data');
    //         //  Route::get('professional' , 'showProfessionalForm')->name('professional.data');
    //         //  Route::get('family' , 'showFamilyDetails')->name('families.data');
    //         //  Route::get('hobbies' , 'showHobbiesForm')->name('hobbies.data');
    //         Route::post('add-profile-data', 'addProfileData')->name('profile.data');
    //         //  Route::post('add-religious-information-data' , 'storeReligiousInformation')->name('religiousInformation.data');
    //         //  Route::get('edit-profile-data','edit')->name('editProfile.data');
    //         //  Route::post('update-profile-data' , 'update')->name('updateProfile.data');
    //         //  Route::post('delete-profile-data/{id}' , 'destroy')->name('deleteProfile.Data');
    //     });

    //     Route::controller(ReligiousInformationController::class)->group(function () {
    //         Route::get('add-religious-information-form', 'showReligiousForm')->name('religious.data');
    //         Route::post('add-religious-information-data', 'storeReligiousInformation')->name('religiousInformation.data');
    //         Route::get('edit-religious-information/{id}', 'edit')->name('edit.religiousInformation');
    //         Route::post('update-religious-information', 'update')->name('updateReligious.Information');
    //         Route::post('delete-religious-information/{id}', 'destroy')->name('deleteReligious.Information');
    //     });

    //     Route::controller(LocationController::class)->group(function () {
    //         Route::get('add-location-data', 'addLocationForm')->name('addLocation.data');
    //         Route::post('store-location-data', 'storeLocationData')->name('storeLocation.data');
    //         Route::get('edit-location-data', 'edit')->name('editLocation.data');
    //         Route::post('update-location-data', 'updateLocation')->name('updateLocation.data');
    //         Route::post('delete-location/{id}', 'destroy')->name('deleteLocation.data');
    //     });

    //     Route::controller(ProfessionalInformationController::class)->group(function () {
    //         Route::get('add-professional-information', 'addProfessionalInformation')->name('addProfessional.Information');
    //         Route::post('store-professional-information', 'storeProfessionalInformation')->name('storeProfessional.Information');
    //         Route::get('edit-professional-information/{id}', 'edit')->name('editProfessional.Information');
    //         Route::post('update-professional-information', 'updateProfessionalInformation')->name('updateProfessional.Information');
    //         Route::post('delete-professional-information/{id}', 'destroy')->name('deleteProfessional.Information');
    //     });

    //     Route::controller(FamilyDetailsController::class)->group(function () {
    //         Route::get('add-family-details', 'addFamilyDetails')->name('addFamily.details');
    //         Route::post('store-family-details', 'storeFamilyDetails')->name('storefamily.details');
    //         Route::get('edit-family-details', 'edit')->name('editFamily.details');
    //         Route::post('update-family-details', 'updateFamilyDetails')->name('updateFamily.details');
    //         Route::post('delete-family-details/{id}', 'destroy')->name('deleteFamily.details');
    //     });

    //     Route::controller(HobbiesController::class)->group(function () {
    //         Route::get('add-hobbies', 'addHobbies')->name('addHobbies.details');
    //         Route::post('store-hobbies', 'storeHobbies')->name('storeHobbies.details');
    //         Route::get('edit-hobbies/{id}', 'edit')->name('editHobbies.details');
    //         Route::post('update-hobbies', 'updateHobbies')->name('updateHobbies.details');
    //         Route::post('delete-hobbies/{id}', 'destroy')->name('deleteHobbies.details');
    //     });

    //     Route::controller(FavouriteController::class)->group(function() {
    //         Route::get('favourite','index')->name('favourite');
    //     });

    //     Route::controller(ContactController::class)->group(function() {
    //         Route::get('contact-us','index')->name('contact.us');
    //     });

    //     Route::controller(AboutController::class)->group(function() {
    //         Route::get('about','index')->name('about');
    //     });
    // });
});
