<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class UserRepository implements RepositoryInterface
{

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data): void
    {
        User::create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return void
     */
    public function update(array $data, int $id): void
    {
        User::whereId($id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        User::destroy($id);
    }

    /**
     * @param int $id
     *
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|User|null
     */
    public function findOneBy(string $field, string $value): Collection|User|null
    {
        return User::where($field, '=', $value)->first();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|User[]|null
     */
    public function findAllBy(string $field, string $value): Collection|array|null
    {
        return User::where($field, '=', $value)->get();
    }
}
