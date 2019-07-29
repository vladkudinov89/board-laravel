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

    protected $fillable = [
        'project_id',
        'description'
    ];
}
