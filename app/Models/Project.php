<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_amount',
        'collection_amount',
        'currency',
        'status',
        'requester_id',
    ];

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}
