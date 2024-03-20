<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    public $hidden = ['contract_id', 'pivot'];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function certifications(): BelongsToMany
    {
        return $this->belongsToMany(Certification::class);
    }
}
