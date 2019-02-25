<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Groups\WallGroup;

class Customer extends Model
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
    protected $fillable = ['name','street','street_two','city','state','zipcode','country','business_id','service_team_geo_area','company_type'];

    public function groups()
    {
        return $this->hasMany(WallGroup::class);
    }
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }
}
