<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\UserTrackedStock;

class UserTrackedStockRepository implements RepositoryInterface
{

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return UserTrackedStock::all();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data): void
    {
        UserTrackedStock::created($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return void
     */
    public function update(array $data, int $id): void
    {
        UserTrackedStock::whereId($id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        UserTrackedStock::destroy($id);
    }

    /**
     * @param int $id
     *
     * @return UserTrackedStock|null
     */
    public function find(int $id): ?UserTrackedStock
    {
        return UserTrackedStock::find($id);
    }

    /**
     * @param string $field
     * @param string $value
     * @return Collection|UserTrackedStock|null
     */
    public function findOneBy(string $field, string $value): Collection|UserTrackedStock|null
    {
        return UserTrackedStock::where($field, '=', $value)->first();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|UserTrackedStock[]|null
     */
    public function findAllBy(string $field, string $value): Collection|array|null
    {
        return UserTrackedStock::where($field, '=' , $value)->get();
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $idKey
     *
     * @return Collection|UserTrackedStock|null
     */
    public function findAllIdsBy(string $field, string $value, string $idKey): Collection|UserTrackedStock|null
    {
        return UserTrackedStock::where($field, '=', $value)->pluck($idKey)->get();
    }

    /**
     * @param array $data
     *
     * @return Collection|UserTrackedStock
     */
    public function findOneByMany(array $data): UserTrackedStock|Collection
    {
        return UserTrackedStock::where($data)->first();
    }
}
