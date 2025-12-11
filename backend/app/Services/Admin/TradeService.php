<?php

namespace App\Services\Admin;

use App\Repositories\Admin\TradeRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class TradeService
{
    protected $repo;

    public function __construct(TradeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data)
    {
        $trade = $this->repo->create($data);

        return $trade;
    }

    public function update($trade, array $data)
    {
        $trade = $this->repo->update($trade, $data);

        return $trade;
    }

    public function delete($trade)
    {
        return $this->repo->delete($trade);
    }
}
