<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\kontrol;
use App\Http\Controllers\Yonet;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Formislemleri;
use App\Http\Controllers\Veritabaniislemleri;
use App\Http\Controllers\Modelislemleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Meeting;

/*Route::get('/', function () {
    $meeting_start = \Carbon\Carbon::create('2022-09-21 15:35:00');
    $meeting_end = \Carbon\Carbon::create('2022-09-21 15:35:00')->add(30, 'minute');

    $meetings = Meeting::where('meeting_at', '>=', $meeting_start)->where('meeting_at', '<=', $meeting_end)->dd();

    return $meetings;
});

/*
Route::get('/deneme', function(){
    return view('ornek');
});
*/

// Route::get('/php/{isim}',[kontrol::class,'test']);

// Route::get('/web',[Yonet::class,'site'])->name('web');

// Route::get('/form',[Formislemleri::class,'gorunum']);

// Route::middleware('arakontrol')->post('/form-sonuc',[Formislemleri::class,'sonuc'])->name('sonuc');

// Route::get('/ekleme',[Veritabaniislemleri::class,'ekle']);
// Route::get('/guncelleme',[Veritabaniislemleri::class,'guncelle']);
// Route::get('/silme',[Veritabaniislemleri::class,'sil']);
// Route::get('/okuma',[Veritabaniislemleri::class,'oku']);

// Route::get('/modelliste',[Modelislemleri::class,'liste']);

// // Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
