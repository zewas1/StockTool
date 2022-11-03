<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\UserOwnedStock;

class UserOwnedStockRepository implements RepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return UserOwnedStock::all();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data): void
    {
        UserOwnedStock::create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return void
     */
    public function update(array $data, int $id): void
    {
        UserOwnedStock::whereId($id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        UserOwnedStock::destroy($id);
    }

    /**
     * @param int $id
     *
     * @return UserOwnedStock|null
     */
    public function find(int $id): ?UserOwnedStock
    {
        return UserOwnedStock::find($id);
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|UserOwnedStock|null
     */
    public function findOneBy(string $field, string $value): Collection|UserOwnedStock|null
    {
        return UserOwnedStock::where($field, '=', $value)->first();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|UserOwnedStock[]|null
     */
    public function findAllBy(string $field, string $value): Collection|array|null
    {
        return UserOwnedStock::where($field, '=', $value)->get();
    }
}
