<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Slot extends Model
{
    use HasFactory;
    protected $table = 'slots';

    protected $fillable = [ 'start_time ','end_time'];

    public function appointSlot()
    {
        return $this->hasOne(Appointment::class,'slot_id');
    }

    public function bookedSlot()
    {
        return $this->hasOne(SlotAvailability::class,'slot_id');
       
    }
}