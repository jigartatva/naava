<?php

namespace App\Models\Maintainers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Groups\WallGroup;
class MaintenanceContact extends Model
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
    protected $fillable = ['group_id','name','title','phone','mobile_phone','email','address','contact_type','priority_contacting_method','secondary_contacting_method','spoken_language','notes'];

    public function group()
    {
        return $this->belongsTo(WallGroup::class,'group_id','id');
    }
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }
    public function setTitleAttribute($value)
    {
        return $this->attributes['title'] = ucwords(strtolower($value));
    }
    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = trim(strtolower($value));
    }
}
