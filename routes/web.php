<?php

use App\Livewire\AboutUsPage;
use App\Livewire\ContactUsPage;
use App\Livewire\HomePage;
use App\Livewire\RoomDetailsPage;
use App\Livewire\RoomPage;
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
