<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_detail extends Model
{
    use HasFactory;
    protected $table = 'bank_details';

    protected $fillable = [ 'acc_hold_name','account_number','bank_name','ifsc_code','client_id'];
}
