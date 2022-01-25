<?php

namespace App\Http\Controllers;

use App\Events\NovaSerie;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Episodio;
use App\Models\Serie;
use App\Models\Temporada;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{



    public function index(Request $request)
    {
        //obtendo mensagem na sessão
        $mensagem = $request->session()->get('mensagem');

        //$series = Serie::all();
        $series = Serie::query()->orderBy('nome')->get();
        return view(
            'series',
            [
                'series' => $series,
                'mensagem' => $mensagem
            ]
        );
    }


    public function create(Request $request){
        return view('create');

    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie){

       // $request->validate([
       //     'nome'=> 'required|min:3'
       // ]);
       //Posso ja utilizar aqui, mas a forma adequada e q crie um request, q estou colocando junto com a funcao (SeriesFormRequest $request)

       $capa = null;
       if($request->hasFile('capa')){
          $capa = $request->file('capa')->store('series');
       }


        $nome = $request->nome;
        $qtdTemporadas = $request->qtd_temporadas;
        $qtdEpisodios = $request->qtd_episodios;
        $capa = $capa;

        $serie = $criadorDeSerie->criarSerie($nome,$qtdTemporadas,$qtdEpisodios,$capa);
     //   echo("Série criada com id { $serie->id } e nome { $serie->nome } " );
    /* Forma mais longa de estar fazendo
        $serie = new Serie();
        $serie->nome = $nome;
        $serie->id = 1544;
        $serie->save();
    */
        //Criando um evento
        $eventoNovaSerie = new NovaSerie($nome,$qtdTemporadas,$qtdEpisodios);
        //Emite o evento
        event($eventoNovaSerie);


    //Obtendo a sessão do usuário e inserindo uma msg para obter na view
    //$request->session()->put('mensagem', "Série {$serie->nome} criada!");
    $request->session()->flash('mensagem', "Série {$serie->nome} criada!");

    //return redirect('/series');
    return redirect()->route('series.index');

    }


    public function destroy(Request $request, RemovedorSerie $removedorSerie){

        $nomeSerie = $removedorSerie->removerSerie($request->id);

        $request->session()->flash('mensagem', "Série deletada");
       //return redirect('/series');
       return redirect()->route('series.index');

    }

    public function update(int $id, Request $request)
{
    $novoNome = $request->nome;
    $serie = Serie::find($id);
    $serie->nome = $novoNome;
    $serie->save();
}


}
