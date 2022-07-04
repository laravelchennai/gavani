<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait UserStamp
{
    /**
     * Boot Method of the Trait.
     *
     * @return void
     */
    public static function bootUserStamp()
    {
        static::creating(function (Model $model) {
            $model->created_by = optional(Auth::user())->id;
        });

        static::updating(function (Model $model) {
            $model->updated_by = optional(Auth::user())->id;
        });
    }
}
