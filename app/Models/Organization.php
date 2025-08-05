<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    protected $fillable = [
        'id',
        'organization_type_id',
        'website',
        'employee_numbers_id',
        'established_year',
        'annual_budgets_id',
        'organization_sectors',
        'branches',
    ];

    protected $casts = [
        'organization_sectors' => 'array',
        'branches' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id');
    }

    public function employeeNumber()
    {
        return $this->belongsTo(EmployeeNumber::class, 'employee_numbers_id');
    }

    public function annualBudget()
    {
    return $this->belongsTo(AnnualBudget::class, 'annual_budgets_id');
    }

    public function organizationSector()
    {
        return $this->belongsTo(OrganizationSector::class, 'organization_sectors_id');
    }


}
