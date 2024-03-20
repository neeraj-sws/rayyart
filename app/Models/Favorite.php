<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorites';

    protected $fillable = [ 'user_id','client_id','type'];

    function userFav()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    function clientFav()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }
}
