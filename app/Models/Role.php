<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function hasPermission($permissionSlug)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->slug == $permissionSlug) {
                return true;
            }
        }
        return false;
    }
}
