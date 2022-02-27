<?php

namespace App\Http\Service;

use App\Repository\OrderRepository;

class OrderService extends Service
{
  public function __construct(OrderRepository $repository)
  {
    $this->repository = $repository;
  }
}