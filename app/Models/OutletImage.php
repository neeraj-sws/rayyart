<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletImage extends Model
{
    use HasFactory;
    protected $table = 'outlet_images';

    protected $fillable = [ 'file'];

    public $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->file) {
            return url('/uploads/client/'.$this->file);
        }
        else{
            return null;
        }

    }
}
