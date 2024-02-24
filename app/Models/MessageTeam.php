<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTeam extends Model
{
    use HasFactory;

    protected $table = "messages_team";
    protected $primaryKey = 'id_message_team'; //chave primaria
    protected $fillable = [
        'id_user',
        'id_team',
        'text',
        'file',
        'type_file'
    ];
}
