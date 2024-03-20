<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;

class Amenity extends Model
{
    use HasFactory;
    protected $table = 'amenities';

    protected $fillable = [ 'title','icon','description','status'];

    function photo()
    {
        return $this->belongsTo(Upload::class, 'icon');
    }

    public $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->photo) {
            return url('/uploads/amenity/'.$this->photo->file);
        }
        else{
            return null;
        }

    }
    
}

  
   