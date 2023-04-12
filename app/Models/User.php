<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching($role);
    }

    public function hasPermission(string $slug): bool
    {
        $permissions = $this->roles
            ->flatMap(function (Role $role) {
                return $role->permissions;
            })
            ->pluck('slug');

        return $permissions->contains($slug);
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->pluck('id')->intersect([$role])->count()) {
                return true;
            }
        }
        return false;
    }
}
