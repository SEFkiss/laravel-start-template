<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $fillable = [
        'name',
        'display_name',
        'description',
    ];
}
