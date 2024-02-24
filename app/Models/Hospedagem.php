<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospedagem extends Model
{
    use HasFactory;
    
    //  Verifica se está na hospedagem para mudar caminhos das imagens no banco
    public function isHospedagem(){
        return 0;
    }
}
