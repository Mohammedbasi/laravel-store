<?php

namespace App\Concerns;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    }

    public function hasAbility($ability)
    {
        // if the ability in one role is deny then the priority for (deny)
        $denied = $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', '=', 'deny');
        })->exists();

        if ($denied) {
            return false;
        }
        // to this line 

        // if the (allow) has more priority than deny
        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', '=', 'allow');
        })->exists();
    }
}
