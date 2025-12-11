<?php

namespace App\Repositories\Admin;

use App\Models\Trade;

class TradeRepository
{
    public function getAll()
    {
        return Trade::orderBy('name')->get();
    }

    public function paginate($limit = 10)
    {
        return Trade::paginate($limit);
    }

    public function find($id)
    {
        return Trade::findOrFail($id);
    }

    public function create(array $data)
    {
        return Trade::create($data);
    }

    public function update(Trade $trade, array $data)
    {
        $trade->update($data);
        return $trade;
    }

    public function delete(Trade $trade)
    {
        return $trade->delete();
    }
}
