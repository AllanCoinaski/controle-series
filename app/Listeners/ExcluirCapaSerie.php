<?php

namespace App\Listeners;

use App\Events\SerieApagada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
Use Illuminate\Support\Facades\Storage;
class ExcluirCapaSerie implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SerieApagada  $event
     * @return void
     */
    public function handle(SerieApagada $event)
    {
        $serie = $event->serie;
        //Deletando a imagem da capa
        if($serie->capa){
            Storage::delete($serie->capa);
        }
    }
}
