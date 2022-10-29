<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\TrackedStock;
use Illuminate\Database\Eloquent\Collection;

class TrackedStockRepository implements RepositoryInterface
{

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return TrackedStock::all();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data): void
    {
        TrackedStock::create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return void
     */
    public function update(array $data, int $id): void
    {
        TrackedStock::whereId($id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        TrackedStock::destroy($id);
    }

    /**
     * @param int $id
     *
     * @return TrackedStock|null
     */
    public function find(int $id): ?TrackedStock
    {
        return TrackedStock::find($id);
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|TrackedStock|null
     */
    public function findOneBy(string $field, string $value): Collection|TrackedStock|null
    {
        return TrackedStock::where($field, '=', $value)->first();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|TrackedStock[]|null
     */
    public function findAllBy(string $field, string $value): Collection|array|null
    {
        return TrackedStock::where($field, '=', $value)->get();
    }

    /**
     * @param array $data
     *
     * @return Collection|TrackedStock
     */
    public function findOneByMany(array $data): Collection|TrackedStock
    {
        return TrackedStock::where($data)->first();
    }
}
