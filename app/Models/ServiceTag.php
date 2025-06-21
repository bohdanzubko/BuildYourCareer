<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceTag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_tag_relations', 'tag_id', 'service_id');
    }
}
