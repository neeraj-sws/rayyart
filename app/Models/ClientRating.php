<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRating extends Model
{
    use HasFactory;

    protected $table = 'clientratings';

    protected $fillable = [ 'user_id','client_id','rating','review'];

}
