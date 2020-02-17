<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function task()
    {
        return $this->hasMany(Task::class);
    }
}
