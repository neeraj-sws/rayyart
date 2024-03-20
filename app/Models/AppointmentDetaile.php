<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;

class AppointmentDetaile extends Model
{
    use HasFactory;
    protected $table = 'appointment_details';

    protected $fillable = [ 'clientserviceprices_id','appointments_id'];

    function clientServePriceData()
    {
        return $this->belongsTo(ClientServicePrice::class,'clientserviceprices_id');
    }
}
