<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceTag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_tag_relations');
    }
}
