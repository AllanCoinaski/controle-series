<?php

namespace App\Services;

use App\Models\Serie;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{

    public function criarSerie(
        string $nomeSerie,
        int $qtdTemporadas,
        int $qtdEpisodios,
        ?string $capa,
    ):Serie
    {
        DB::beginTransaction();
        $serie = Serie::create([
            'nome' => $nomeSerie,
            'capa' =>$capa
        ]);
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            for ($j = 1; $j <= $qtdEpisodios; $j++) {
                $temporada->episodios()->create(['numero' => $j]);
            }
        }
        DB::commit();

        return $serie;

    }
}
?>
