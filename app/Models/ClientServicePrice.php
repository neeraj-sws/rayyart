<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientServicePrice extends Model
{
    use HasFactory;
    protected $table = 'clientserviceprices';

    protected $fillable = [ 'price','services','client_id','category_id','sub_category_id'];

    function services()
    {
        return $this->hasMany(Services::class);
    }

    function CatId()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    function subCate()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function clientServePrice()
    {
        return $this->hasMany(Appointment::class,'clientserviceprices_id');
    }


}
