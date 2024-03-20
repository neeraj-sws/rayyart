<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Client  extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'category_id',
        'opentime',
        'closetime',
        'outlet_name',
        'owner_adhar_card',
        'owner_photo',
        'outlet_address',
        'bank_details',
        'gumasta',
        'outlet_images',
        'rent_agreement',
        'amenities_id',
        'latitude',
        'longitude',
        'owner_phonenumber',
        'city',
        'rating',
        'tax',
        'state_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    
    function CatId()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    
     function CityId()
    {
        return $this->belongsTo(City::class,'city');
    }

    function bankId()
    {
        return $this->belongsTo(Bank_detail::class,'bank_details');
    }

    function Image()
    {
        return $this->belongsTo(Upload::class,'owner_photo');
    }

    function gumastaImage():BelongsTo
    {
        return $this->belongsTo(Upload::class,'gumasta');
    }

    function outletImages()
    {
        return $this->belongsTo(Upload::class,'outlet_images');
    }

    function servicePrice()
    {
        return $this->hasMany(ClientServicePrice::class,'client_id');
    }

    function favCdata()
    {
        return $this->hasMany(Favorite::class,'client_id');
    }
    
    

    // function clientAmenity()
    // {
    //         return $this->belongsTo(ClientAmenity::class, 'amenities_id');
    // }
    public function clientAppointment()
    {
        return $this->hasMany(Appointment::class,'client_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id','title','icon');
    }

    public function service()
    {
        return $this->hasMany(ClientServicePrice::class, 'client_id');
    }

    public function Bankdetails()
    {
        return $this->belongsTo(Bank_detail::class, 'bank_details');
    }

    public function Amenities()
    {
        return $this->belongsTo(Amenity::class, 'amenities_id')->select('id','title','icon');
    }

    public $appends = ['image_url','gumasta_url'];

    public function getImageUrlAttribute()
    {
        if ($this->Image) {
            return url('/uploads/client/'.$this->Image->file);
        }
        else{
            return null;
        }

    }

    public function getGumastaUrlAttribute()
    {
    //    echo "<pre>"; print_r($this->gumastaImage->file); die;
       if ($this->gumastaImage) {
        return url('/uploads/client/'.$this->gumastaImage->file);
    }
    else{
        return null;
    }
       
    }








}
