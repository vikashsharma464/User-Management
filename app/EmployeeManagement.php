<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class EmployeeManagement extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    const GENDER_RADIO = [

    ];

    protected $appends = [
        'photo',
    ];

    public $table = 'employee_managements';

    protected $dates = [
        'dob',
        'doj',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'doj',
        'dob',
        'gender',
        'mobile',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
        'employee_name',
        'employee_email',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getPhotoAttribute()
    {
        $files = $this->getMedia('photo');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
        });

        return $files;
    }

    public function getDobAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDojAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDojAttribute($value)
    {
        $this->attributes['doj'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
