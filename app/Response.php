<?php

namespace CommunityPoem;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['status'];
    protected $dates = ['approved_at'];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function getIsApprovedAttribute()
    {
        return filled($this->approved_at);
    }

    public function getStatusAttribute()
    {
        return filled($this->approved_at) ? 'approved' : 'unapproved';
    }
}
