<?php

namespace App\Http\Service;

use App\Repository\OrderRepository;

class OrderService
{
  protected $repository;

  public function __construct(OrderRepository $repository)
  {
    $this->repository = $repository;
  }
}