<?php

use App\Livewire\Admin\Aboutus;
use App\Livewire\Admin\Banners;
use App\Livewire\Admin\BookingCreate;
use App\Livewire\Admin\BookingEdit;
use App\Livewire\Admin\Bookings;
use App\Livewire\Admin\BookingView;
use App\Livewire\Admin\ChangePassword;
use App\Livewire\Admin\CompanyDetails;
use App\Livewire\Admin\CreateGallery;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Galleries;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\RoomCreate;
use App\Livewire\Admin\RoomEdit;
use App\Livewire\Admin\Rooms;
use App\Livewire\Admin\RoomServices;
use App\Livewire\Admin\RoomType;
use App\Livewire\Admin\RoomTypeCreate;
use App\Livewire\Admin\RoomTypeEdit;
use App\Livewire\Admin\RoomTypes;
use App\Livewire\Admin\RoomTypeView;
use App\Livewire\Admin\RoomView;
use App\Livewire\Admin\ServiceCreate;
use App\Livewire\Admin\ServiceEdit;
use App\Livewire\Admin\Services;
use App\Livewire\Admin\ServiceView;
use App\Livewire\Admin\Test;
use App\Livewire\Admin\TestimonialCreate;
use App\Livewire\Admin\TestimonialEdit;
use App\Livewire\Admin\Testimonials;
use App\Livewire\Admin\TestimonialView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public route for admin login
Route::get('admin/login', Login::class)->name('admin.login');

// Protected routes for admin and staff
Route::middleware('admin')->group(function () {

    Route::get('admin/dashboard', Dashboard::class)->name('admin.dashboard');

    Route::get('admin/banner', Banners::class)->name('admin.banner');

    Route::get('admin/services', Services::class)->name('admin.services');
    Route::get('admin/services/create', ServiceCreate::class)->name('admin.service-create');
    Route::get('/admin/services/edit/{id}', ServiceEdit::class)->name('admin.service-edit');
    Route::get('/admin/services/{serviceId}', ServiceView::class)->name('admin.service-view');

    Route::get('admin/room-types', RoomTypes::class)->name('admin.room-types');
    Route::get('admin/room-types/create', RoomTypeCreate::class)->name('admin.roomtype-create');
    Route::get('/admin/room-types/edit/{id}', RoomTypeEdit::class)->name('admin.roomtype-edit');
    Route::get('/admin/room-types/{roomtypeId}', RoomTypeView::class)->name('admin.roomtype-view');

    Route::get('admin/rooms', Rooms::class)->name('admin.rooms');
    Route::get('admin/rooms/create', RoomCreate::class)->name('admin.room-create');
    Route::get('/admin/rooms/edit/{id}', RoomEdit::class)->name('admin.room-edit');
    Route::get('/admin/rooms/{roomId}', RoomView::class)->name('admin.room-view');

    //Route::get('admin/room-services', RoomServices::class)->name('admin.room-services');

    Route::get('admin/bookings', Bookings::class)->name('admin.bookings');
    Route::get('admin/bookings/create', BookingCreate::class)->name('admin.booking-create');
    Route::get('/admin/bookings/edit/{id}', BookingEdit::class)->name('admin.booking-edit');
    Route::get('/admin/bookings/{bookingId}', BookingView::class)->name('admin.booking-view');

    Route::get('admin/galleries', Galleries::class)->name('admin.galleries');
    Route::get('admin/galleries/create', CreateGallery::class)->name('admin.gallery-create');

    Route::get('admin/testimonials', Testimonials::class)->name('admin.testimonials');
    Route::get('admin/testimonials/create', TestimonialCreate::class)->name('admin.testimonial-create');
    Route::get('/admin/testimonials/edit/{id}', TestimonialEdit::class)->name('admin.testimonial-edit');
    Route::get('/admin/testimonials/{testId}', TestimonialView::class)->name('admin.testimonial-view');

    Route::get('admin/change-password', ChangePassword::class)->name('admin.change-password');
    Route::get('admin/company-details', CompanyDetails::class)->name('admin.company-details');
    Route::get('admin/about-us', Aboutus::class)->name('admin.about-us');

    Route::get('admin/test', Test::class)->name('admin.test');


    Route::get('admin/logout', function () {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    })->name('admin.logout');
});
