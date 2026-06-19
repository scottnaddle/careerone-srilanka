<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PortfolioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Portfolio $portfolio): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Trainee $trainee, Portfolio $portfolio)
    {
        return $trainee->id === $portfolio->trainee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Trainee $trainee, Portfolio $portfolio)
    {
        return $trainee->id === $portfolio->trainee_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Portfolio $portfolio): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Portfolio $portfolio): bool
    {
        //
    }
}
