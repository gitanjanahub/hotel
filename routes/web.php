<?php

use App\Livewire\AboutUsPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ContactUsPage;
use App\Livewire\ForgotPasswordPage;
use App\Livewire\HomePage;
use App\Livewire\LoginPage;
use App\Livewire\RegisterPage;
use App\Livewire\RoomDetailsPage;
use App\Livewire\RoomPage;
use App\Livewire\TestPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomePage::class)->name('home');
Route::get('/rooms', RoomPage::class)->name('rooms');
Route::get('/rooms/{slug}',RoomDetailsPage::class);
Route::get('/about-us', AboutUsPage::class)->name('about');
Route::get('/contact-us', ContactUsPage::class)->name('contact');
//Route::get('/checkout',CheckoutPage::class);

Route::middleware('auth')->group(function (){

    Route::get('/logout', function (){
      auth()->logout();
      return redirect('/');
    });
Route::get('/checkout', CheckoutPage::class)->name('checkout');
});


//Route::get('/login',LoginPage::class)->name('login');
Route::get('/register',RegisterPage::class);
Route::get('/forgot-password',ForgotPasswordPage::class)->name('password.request');
Route::get('/test',TestPage::class);
