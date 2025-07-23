<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = [
        'name',
        'email',
        'position',
        'department',
        'hire_date'
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];
    
    /**
     * The attributes that should be encrypted.
     *
     * @var array
     */
    protected $encryptable = [
        'name',
        'email',
    ];

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}