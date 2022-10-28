<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Constants\UserRoleConstants;

class TrackedStockPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->haveThePower($user->role, UserRoleConstants::ADMIN);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->haveThePower($user->role, UserRoleConstants::ADMIN);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function edit(User $user): bool
    {
        return $user->haveThePower($user->role, UserRoleConstants::ADMIN);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->haveThePower($user->role, UserRoleConstants::ADMIN);
    }
}
