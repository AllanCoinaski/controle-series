<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Serie extends Model
{
    use HasFactory;
    protected $fillable = ['nome','id','capa'];

    //indicando quee uma serie possui varias temporadas
    public function temporadas(){
        return $this->hasMany(Temporada::class);
    }

     public function getCapaUrlAttribute(){
         if($this->capa){
             return Storage::url($this->capa);
         }
         return Storage::url('serie/sem-imagem.jpeg');

     }


}


