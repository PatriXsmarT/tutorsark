<?php

namespace App\Traits;

use Exception;
use App\Models\Ability;
use Illuminate\Support\Collection;

trait HasAbilities
{
    /**
     * Assign a ability to the model
     *
     * @param String|Array|Object $ability
     *
     * @return $this
     */
    public function allowTo($ability)
    {
        return $this->assignAbilities($ability);
    }

    /**
     * Get the combination of the model abilities and the ones through a relationship.
     */
    public function combinedAbilitiesThrough($relationship)
    {
        $relationshipAbilities = $this->{$relationship}->map(function ($relationshipModel) {
            return $relationshipModel->abilities;
        })->flatten()->unique('id');

        return $this->abilities->merge($relationshipAbilities);
    }

    /**
     * Get all of the abilities for the model.
     */
    public function abilities()
    {
        return $this->morphToMany(Ability::class, 'abilitable')->withTimeStamps();
    }

    /**
     * Check if the model has all of the given abilities.
     *
     * @param String|Array|Object $abilities
     *
     * @return Bool
     */
    public function hasAllAbilities($abilities): Bool
    {
        return $this->hasAbilities($abilities);
    }

     /**
     * Check if the model has any of the given abilities.
     *
     * @param String|Array|Object $abilities
     *
     * @return Bool
     */
    public function hasAnyAbility($abilities): Bool
    {
        if (is_array($abilities)) {

            return count($this->matchedAbilities($abilities)) > 0;
        }

        return $this->hasAbility($abilities);
    }

    /**
     * Check if the model has all of the given abilities.
     *
     * @param String|Array|Object $abilities
     *
     * @return Bool
     */
    public function hasAbilities($abilities): Bool
    {
        if (is_array($abilities)) {

            return count($abilities) == count($this->matchedAbilities($abilities));
        }

        return $this->hasAbility($abilities);
    }

    /**
     * Check if the model has a particular ability.
     *
     * @param String|Array|Object $ability
     *
     * @return Bool
     */
    public function hasAbility($ability): Bool
    {
        if(is_array($ability)){

            return $this->hasAbilities($ability);
        }

        if(is_string($ability) || is_numeric($ability)){

            $ability = $this->getStoredAbility($ability);
        }

        if ($ability instanceof Ability) {

            return $this->abilities()->contains($ability);
        }

        throw new Exception('The given ability is not and instance of App\Modes\Ability model');
    }

    /**
     * Assign the given abilities to the model
     *
     * @param String|Array|Object $abilities
     *
     * @return $this
     */
    public function assignAbilities($abilities)
    {
        if (is_array($abilities)) {

            foreach ($abilities as $ability) {

                $this->assignAbility($ability);
            }

            return $this;
        }

        return $this->assignAbility($abilities);
    }

    /**
     * Assign a ability to the model
     *
     * @param String|Array|Object $ability
     *
     * @return $this
     */
    public function assignAbility($ability)
    {
        if(is_array($ability)){

            return $this->assignAbilities($ability);
        }

        if(is_string($ability) || is_numeric($ability)){

            $ability = $this->getStoredAbility($ability);
        }

        if ($ability instanceof Ability) {

            $this->abilities()->syncWithoutDetaching($ability);

            return $this;
        }

        throw new Exception('The given ability is not and instance of App\Models\Ability model');
    }

    /**
     * Revoke abilities assigned to the model
     *
     * @param String|Array|Object $abilities
     *
     * @return $this
     */
    public function revokeAbilities($abilities)
    {
        if (is_array($abilities)) {

            foreach ($abilities as $ability) {

                return $this->revokeAbility($ability);
            }
        }

        return $this->revokeAbility($abilities);
    }

    /**
     * Revoke a ability assigned to the model
     *
     * @param String|Array|Object $ability
     *
     * @return $this
     */
    public function revokeAbility($ability)
    {
        if(is_array($ability)){

            return $this->revokeAbilities($ability);
        }

        if(is_string($ability) || is_numeric($ability)){

            $ability = $this->getStoredAbility($ability);
        }

        if ($ability instanceof Ability) {

            !$this->hasAbility($ability)?:$this->abilities()->detach($ability);

            return $this;
        }

        throw new Exception('The given ability is not and instance of App\Models\Ability model');
    }

    /**
     * Remove all current abilities and set the given ones.
     *
     * @param  String|Array|Object  $abilities
     *
     * @return $this
     */
    public function syncAbilities($abilities)
    {
        $this->abilities()->detach();

        return $this->assignAbility($abilities);
    }

    /**
     * Get the ability stored with by name or id.
     *
     * @param String|Number $ability
     *
     * @return App\Models\Ability
     */
    private function getStoredAbility($ability): Ability
    {
        try {

            if (is_numeric($ability)) {
                return Ability::find($ability);
            }

            if (is_string($ability)) {
                return Ability::whereName($ability)->firstOrFail();
            }
        }
        catch (\Throwable $th)
        {
            throw new Exception('An ability with this name does not exist');
        }
    }

    /**
     * Get the collection of ability names assigned to this model.
     *
     * @return Illuminate\Support\Collection
     */
    public function getAbilityNames(): Collection
    {
        return $this->abilities->pluck('name');
    }

    /**
     * Get the abilities associated with a string by name or id.
     *
     * @param Array $abilities
     */
    public function matchedAbilities($abilities): Array
    {
        return array_intersect($abilities,array_filter($abilities, function($ability){
            return $this->hasAbility($ability);
        }));
    }
}
