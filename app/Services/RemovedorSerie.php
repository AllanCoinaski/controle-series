<?php

namespace App\Services;

use App\Events\SerieApagada;
use App\Jobs\ExcluirCapaSerie;
use App\Models\Episodio;
use App\Models\Serie;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class RemovedorSerie
{
    public function removerSerie(int $serieId):string{
   //Serie::destroy($request->id);
   $nomeSerie = '';
   //Usa o DB transaction para caso der algum erro no meio do caminho, cancelar a exlusao que ja foi realizada, tipo um roolback. POsso usar tbm o DB::beginTransaction que 'e mais facil e melhor
        DB::transaction(function() use($serieId, &$nomeSerie){//& para indicar que nomeSerie sera alterado tbm fora do escopo desta funcao
            $serie = Serie::find($serieId);
            $serieObj = (object) $serie->toArray();
            $nomeSerie = $serie->nome;
            $serie->temporadas->each(function(Temporada $temporada){//o metodo each percorre todas as temporadas
                $temporada->episodios()->each(function(Episodio $episodio){
                    $episodio->delete();
                });
                $temporada->delete();
            });
            $serie->delete();
            //criando evento para apagar imagem da série
           // $evento = new SerieApagada($serieObj);
           // event($evento);


           //usando jobs para apagar a imagem da série
           ExcluirCapaSerie::dispatch($serieObj);


        });

        return $nomeSerie;
    }
}
?>
