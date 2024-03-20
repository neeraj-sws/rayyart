<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;

class SlotAvailability extends Model
{
    use HasFactory;
    protected $table = 'slota_vailabilities';

    protected $fillable = [ 'client_id','slot_id','date'];
}
