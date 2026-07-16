<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'description', 'status'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
