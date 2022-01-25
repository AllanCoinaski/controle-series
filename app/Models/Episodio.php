<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episodio extends Model
{
    use HasFactory;
    protected $fillable = ['numero']; //indico q posso usar
    //Indicando que um episodio possui uma temporada
    public function temporada(){
        return $this->belongsTo(Temporada::class);
    }
}
