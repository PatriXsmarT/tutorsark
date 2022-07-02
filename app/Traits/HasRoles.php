<?php

namespace App\Traits;

use Exception;
use App\Models\Role;
use App\Traits\HasAbilities;
use Illuminate\Support\Collection;

trait HasRoles
{
    use HasAbilities;

    /**
     * Get the combination of the model roles and the ones through a relationship.
     */
    public function combinedRolesThrough($relationship)
    {
        $relationshipRoles = $this->{$relationship}->map(function ($relationshipModel) {
            return $relationshipModel->roles;
        })->flatten()->unique('id');

        return $this->abilities->merge($relationshipRoles);
    }

    /**
     * Get all of the roles for the model.
     */
    public function roles()
    {
        return $this->morphToMany(Role::class, 'roleable')->withTimeStamps();
    }

    /**
     * Check if the model has all of the given roles.
     *
     * @param String|Array|Object $roles
     *
     * @return Bool
     */
    public function hasAllRoles($roles): Bool
    {
        return $this->hasRoles($roles);
    }

     /**
     * Check if the model has any of the given roles.
     *
     * @param String|Array|Object $roles
     *
     * @return Bool
     */
    public function hasAnyRole($roles): Bool
    {
        if (is_array($roles)) {

            return count($this->matchedRoles($roles)) > 0;
        }

        return $this->hasRole($roles);
    }

    /**
     * Check if the model has all of the given roles.
     *
     * @param String|Array|Object $roles
     *
     * @return Bool
     */
    public function hasRoles($roles): Bool
    {
        if (is_array($roles)) {

            return count($roles) == count($this->matchedRoles($roles));
        }

        return $this->hasRole($roles);
    }

    /**
     * Check if the model has a particular role.
     *
     * @param String|Array|Object $role
     *
     * @return Bool
     */
    public function hasRole($role): Bool
    {
        if(is_array($role)){

            return $this->hasRoles($role);
        }

        if(is_string($role)){

            $role = $this->getStoredRole($role);
        }

        if ($role instanceof Role) {

            return $this->roles->contains($role);
        }

        throw new Exception('The given role is not and instance of App\Role model');
    }

    /**
     * Assign the given roles to the model
     *
     * @param String|Array|Object $roles
     *
     * @return $this
     */
    public function assignRoles($roles)
    {
        if (is_array($roles)) {

            foreach ($roles as $role) {

                $this->assignRole($role);
            }

            return $this;
        }

        return $this->assignRole($roles);
    }

    /**
     * Assign a role to the model
     *
     * @param String|Array|Object $role
     *
     * @return $this
     */
    public function assignRole($role)
    {
        if(is_array($role)){

            return $this->assignRoles($role);
        }

        if(is_string($role)){

            $role = $this->getStoredRole($role);
        }

        if ($role instanceof Role) {

            $this->roles()->syncWithoutDetaching($role);

            return $this;
        }

        throw new Exception('The given role is not and instance of App\Role model');
    }

    /**
     * Revoke roles assigned to the model
     *
     * @param String|Array|Object $roles
     *
     * @return $this
     */
    public function revokeRoles($roles)
    {
        if (is_array($roles)) {

            foreach ($roles as $role) {

                return $this->revokeRole($role);
            }
        }

        return $this->revokeRole($roles);
    }

    /**
     * Revoke a role assigned to the model
     *
     * @param String|Array|Object $role
     *
     * @return $this
     */
    public function revokeRole($role)
    {
        if(is_array($role)){

            return $this->revokeRoles($role);
        }

        if(is_string($role)){

            $role = $this->getStoredRole($role);
        }

        if ($role instanceof Role) {

            !$this->hasRole($role)?:$this->roles()->detach($role);

            return $this;
        }

        throw new Exception('The given role is not and instance of App\Role model');
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param  String|Array|Object  $roles
     *
     * @return $this
     */
    public function syncRoles($roles)
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * Get the role stored with by name or id.
     *
     * @param String|Number $role
     *
     * @return App\Models\Role
     */
    private function getStoredRole($role): Role
    {
        try {

            if (is_numeric($role)) {
                return Role::findOrFail($role);
            }

            if (is_string($role)) {
                return Role::whereName($role)->firstOrFail();
            }
        }
        catch (\Throwable $th)
        {
            throw new Exception('A role with this name does not exist');
        }
    }

    /**
     * Get the collection of role names assigned to this model.
     *
     * @return Illuminate\Support\Collection
     */
    public function getRoleNames(): Collection
    {
        return $this->roles->pluck('name');
    }

    /**
     * Get the role associated with a string by name or id.
     *
     * @param Array $roles
     */
    public function matchedRoles($roles): Array
    {
        return array_intersect($roles,array_filter($roles, function($role){
            return $this->hasRole($role);
        }));
    }
}
