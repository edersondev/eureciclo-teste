<?php

namespace App\Repository;

use App\Models\Order;

class OrderRepository
{
  protected $entity;

  public function __construct(Order $entity)
  {
    $this->entity = $entity;
  }
}