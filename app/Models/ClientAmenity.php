<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAmenity extends Model
{
    use HasFactory;
    protected $table = 'clientamenities';

    protected $fillable = [ 'amenities_id','client_id'];

    function allAmentiy()
    {
        return $this->belongsTo(Amenity::class, 'amenities_id');
    }

}
