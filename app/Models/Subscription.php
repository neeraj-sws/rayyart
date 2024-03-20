<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscription';

    protected $fillable = [ 'title','validation','trial_days','price','icon','status'];

    function photo()
    {
        return $this->belongsTo(Upload::class, 'icon');
    }
    
     public function getImageUrlAttribute()
    {
       if ($this->photo) {
        return url('/uploads/admin/'.$this->photo->file);
    }
    else{
        return null;
    }
       
    }
    
}
