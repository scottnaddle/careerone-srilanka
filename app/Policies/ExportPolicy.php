<?php

namespace App\Policies;

use App\Models\AdminUser;
use Filament\Actions\Exports\Models\Export;

class ExportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AdminUser $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Cho phép tất cả users download file export
     */
    public function view(AdminUser $user, Export $export): bool
    {
        return true;
    }
    public function download(AdminUser $user, Export $export): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AdminUser $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AdminUser $user, Export $export): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AdminUser $user, Export $export): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AdminUser $user, Export $export): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AdminUser $user, Export $export): bool
    {
        return true;
    }
}
