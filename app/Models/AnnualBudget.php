<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnualBudget extends Model
{
    public function organizations()
    {
        return $this->hasMany(Organization::class, 'annual_budgets_id');
    }
}