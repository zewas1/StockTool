<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Collection;

class StockRepository implements RepositoryInterface
{

    /**
     * @return Collection|Stock
     */
    public function all(): Collection|Stock
    {
        return Stock::all();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data): void
    {
        // TODO: Implement create() method.
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return void
     */
    public function update(array $data, int $id): void
    {
        Stock::whereId($id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        Stock::destroy($id);
    }

    /**
     * @param int $id
     *
     * @return Stock|null
     */
    public function find(int $id): ?Stock
    {
        return Stock::findOrFail($id)->first();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|Stock|null
     */
    public function findOneBy(string $field, string $value): Collection|Stock|null
    {
        return Stock::where($field, '=', $value)->first();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Collection|Stock[]|null
     */
    public function findAllBy(string $field, string $value): Collection|array|null
    {
        return Stock::where($field, '=', $value)->get();
    }
}
