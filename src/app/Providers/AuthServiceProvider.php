<?php

namespace App\Providers;

use App\Models\Salary;
use App\Policies\SalaryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Salary::class => SalaryPolicy::class,
    ];

    public function boot(): void
    {
        
    }
}