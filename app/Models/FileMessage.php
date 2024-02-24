<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMessage extends Model
{
    use HasFactory;

    protected $table = 'files_messages';
    protected $primaryKey = 'id_files_messages';
    protected $fillable = [
        'file_name',
        'id_message_team',
        'type_file',
        'path_file'
    ];
    public $timestamps = false;
}
