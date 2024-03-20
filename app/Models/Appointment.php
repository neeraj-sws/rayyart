<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';

   protected $fillable = [ 'user_id','client_id','price','date','start_time','end_time','slot_id','sub_total','tax'];


    function userData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function clientData()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    function clientServePriceData()
    {
        return $this->belongsTo(ClientServicePrice::class,'clientserviceprices_id');
    }

    function appointmentDetail()
    {
        return $this->hasMany(AppointmentDetaile::class, 'appointments_id');
    }

    function timeSlot()
    {
        return $this->belongsTo(Slot::class, 'slot_id'); 
    }

}

?>