<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue //ShouldQueue para executar assincrono, por padrao 'e sincrono
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
     * @param  \App\Events\NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
           $email = new \App\Mail\NovaSerie(
            $event->nomeSerie,
            $event->qtdTemporadas,
            $event->qtdEpisodios
        );
        $email->subject('Nova Série adicionada');
        $user = (object)[
            'email'=>'testeallan@hotmail.com',
            'name'=>'Allan'
        ];
        $when = now()->addSecond(5);//Adiciona um delay de 5 segundos para cada envio de e-mail, para isso, tenho q substituir o queue por later
        //Mail::to($user)->queue($email);
        Mail::to($user)->later($when,$email);
    }
}
