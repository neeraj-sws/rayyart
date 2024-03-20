<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisment extends Model
{
    use HasFactory;

    protected $table = 'advertisements';

    protected $fillable = [ 'title','description','image','status'];


    function photo()
    {
        return $this->belongsTo(Upload::class, 'image');
    }

    public $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->photo) {
            return url('/uploads/advertisment/'.$this->photo->file);
        }
        else{
            return null;
        }

    }

}
