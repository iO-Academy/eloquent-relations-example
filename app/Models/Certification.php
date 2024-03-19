<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Certification extends Model
{
    use HasFactory;

    public $hidden = ['pivot'];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
}
