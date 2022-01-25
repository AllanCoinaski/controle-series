<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class TemporadasController extends Controller
{
    public function index (int $serieId){
        //a partir da minha serie, quero obter as temporadas
        $serie = Serie::find($serieId);
        $temporadas = $serie->temporadas;
        return view('temporadas',['temporadas'=>$temporadas,'serie'=>$serie]);
    }
}
