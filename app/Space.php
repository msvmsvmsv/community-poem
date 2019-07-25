<?php

namespace Display;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class Space extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['theme'];

    public function getThemeAttribute($val)
    {
        return empty($val) ? null : app('Display\\Repositories\\Themes')->get($val);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function unapproved_responses()
    {
        return $this->responses()->whereNull('approved_at');
    }

    public function approved_responses()
    {
        return $this->responses()->whereNotNull('approved_at');
    }

    public function signedUrl()
    {
        return URL::signedRoute('approveResponses',
            ['space' => $this->slug]);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($space) {
            $space->slug = Str::slug($space->name);
        });
    }
}
