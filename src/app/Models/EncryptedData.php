<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EncryptedData extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'field_name',
        'encrypted_value'
    ];

    /**
     * Get the parent model that owns the encrypted data.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}