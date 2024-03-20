<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';

    protected $fillable = [ 'title','status'];

    function catServicesPrice()
    {
        return $this->hasMany(ClientServicePrice::class, 'sub_category_id');
    }
}
