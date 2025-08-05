<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationSector extends Model
{
    public function organizations()
    {
        return $this->hasMany(Organization::class, 'organization_sectors_id');
    }
}
