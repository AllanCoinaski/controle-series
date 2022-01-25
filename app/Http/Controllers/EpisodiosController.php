<?php

namespace App\Http\Controllers;

use App\Models\Episodio;
use App\Models\Temporada;
use Illuminate\Http\Request;

class EpisodiosController extends Controller
{
    public function index (Temporada $temporada, Request $request){
        //a partir da minha temporada, quero obter os episodios
        $episodios = $temporada->episodios;
        $temporadaId = $temporada->id;
        return view('episodios',
        [
            'episodios'=>$episodios,
            'temporadaId'=>$temporada->id,
            'mensagem'=>$request->session()->get('mensagem')
        ]);
    }

    public function update (Temporada $temporada, Request $request){
        $episodiosAssistidos = $request->episodios;
        $temporada->episodios->each(function (Episodio $episodio) use ($episodiosAssistidos){
            $episodio->assistido = in_array($episodio->id, $episodiosAssistidos);
        });
        $temporada->push();//salva os episodios assistidos
        $request->session()->flash('mensagem','Episódios marcados como assistido');
        return redirect()->back();
    }
}
