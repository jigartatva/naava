<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Maintainers\MaintenanceContact;
use App\Models\Customers\Customer;

class WallGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at','created_at','updated_at'];

    /**
     * Which fields may be mass assigned
     * 
     * @var array
     */
    protected $fillable = ['customer_id','name','street','street_two','city','state','zipcode','country','service_team_geo_area'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function maintainers()
    {
    	return $this->hasMany(MaintenanceContact::class,'group_id','id');
    }
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }
    public function setCityAttribute($value)
    {
        return $this->attributes['city'] = ucwords(strtolower($value));
    }
    public function setStateAttribute($value)
    {
        return $this->attributes['state'] = ucwords(trim(strtolower($value)));
    }
    public function setCountryAttribute($value)
    {
        return $this->attributes['country'] = ucwords(trim(strtolower($value)));
    }
}
