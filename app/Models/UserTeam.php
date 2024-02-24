<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    use HasFactory;

    protected $table = 'users_teams';
    protected $primaryKey = 'id_user_team';
    protected $fillable = [
        'id_user',
        'id_team'
    ];
}
