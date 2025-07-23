<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;

class Salary extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowance',
        'tax_deduction',
        'month'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($salary) {
            if ($salary->basic_salary < 0 || $salary->allowance < 0 || $salary->tax_deduction < 0) {
                throw new \InvalidArgumentException('Nilai tidak boleh negatif');
            }
        });

        static::updating(function ($salary) {
            if ($salary->basic_salary < 0 || $salary->allowance < 0 || $salary->tax_deduction < 0) {
                throw new \InvalidArgumentException('Nilai tidak boleh negatif');
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['employee_id', 'basic_salary', 'allowance', 'tax_deduction', 'month'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'basic_salary' => 'encrypted:decimal:2',
        'allowance' => 'encrypted:decimal:2',
        'tax_deduction' => 'encrypted:decimal:2',
        'month' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getTotalSalaryAttribute()
    {
        $total = $this->basic_salary + $this->allowance - $this->tax_deduction;
        return max(0, $total); // Memastikan total gaji tidak negatif
    }

    public function scopeForEmployee(Builder $query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeForMonth(Builder $query, $month)
    {
        return $query->whereMonth('month', $month);
    }

    public function scopeForYear(Builder $query, $year)
    {
        return $query->whereYear('month', $year);
    }
}