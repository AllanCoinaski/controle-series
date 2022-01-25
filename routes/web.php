<?php

use App\Http\Controllers\EntrarController;
use App\Http\Controllers\EpisodiosController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TemporadasController;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/series', [SeriesController::class,'index'])->name('series.index');
Route::get('/series/criar',[SeriesController::class,'create'])->name('series.create');;
Route::post('/series/criar',[SeriesController::class,'store'])->name('series.store');
Route::delete('series/remover/{id}',[SeriesController::class,'destroy'])->name('series.destroy');
Route::post('/series/{id}/editaNome',[SeriesController::class,'update'])->name('series.update');

Route::get('/series/{serieId}/temporadas',[TemporadasController::class,'index'])->name('temporadas.index');

Route::get('/temporadas/{temporada}/episodios',[EpisodiosController::class,'index'])->name('episodios.index');
Route::post('/temporadas/{temporada}/episodios/assistir',[EpisodiosController::class,'update'])->name('episodios.update');

Route::get('/visualizando-email', function(){
    return new \App\Mail\NovaSerie(
        'TWD',
        20,
        18
    );
});

Route::get('/enviando-email', function(){
    $email = new \App\Mail\NovaSerie(
        'TWD - Teste enviando e-mail',
        20,
        18
    );
    $email->subject('Teste de envio de E-mail');
    $user = (object)[
        'email'=>'testeallan@hotmail.com',
        'name'=>'Allan'
    ];
    $when = now()->addSecond(5);//Adiciona um delay de 5 segundos para cada envio de e-mail, para isso, tenho q substituir o queue por later
    //Mail::to($user)->queue($email);
    Mail::to($user)->later($when,$email);
    return('E-mail enviado!');

});
