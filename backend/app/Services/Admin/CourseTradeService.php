<?php

namespace App\Services\Admin;

use App\Repositories\Admin\CourseTradeRepository;

class CourseTradeService
{
    protected $repo;

    public function __construct(CourseTradeRepository $repo)
    {
        $this->repo = $repo;
    }

  public function updateMapping($course, $tradeIds)
    {
        return $this->repo->syncTrades($course, $tradeIds);
    }
}
