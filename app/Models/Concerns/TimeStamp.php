<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

trait TimeStamp
{
    /**
     * Boot Method of the Trait.
     *
     * @return void
     */
    public static function bootTimeStamp()
    {
        static::creating(function (Model $model) {
            $model->{$model->getCreatedAtColumn()} = now();
        });

        static::updating(function (Model $model) {
            $model->{$model->getUpdatedAtColumn()} = now();
        });
    }

    /**
     * Initialize the soft deleting trait for an instance.
     *
     * @return void
     */
    public function initializeTimeStamp()
    {
        $this->casts[$this->getCreatedAtColumn()] = 'datetime';
        $this->casts[$this->getUpdatedAtColumn()] = 'datetime';
    }

    /**
     * Determine if the model uses timestamps.
     *
     * @return bool
     */
    public function usesTimestamps()
    {
        return false;
    }
}
