<?php

namespace App\Models;


/**
 * Class Activity
 * @package App\Models
 *
 * @property int $project_id
 */
class Activity extends AbstractBaseModel
{
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
