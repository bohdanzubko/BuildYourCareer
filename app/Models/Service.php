<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'service_skill', 'service_id', 'skill_id');
    }

    public function tags()
    {
        return $this->belongsToMany(ServiceTag::class, 'service_tag_relations', 'service_id', 'tag_id');
    }

    public function users()
    {
        return $this->belongsToMany(Service::class, 'user_services');
    }
}


