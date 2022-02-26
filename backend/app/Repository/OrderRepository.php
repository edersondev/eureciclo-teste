<?php

namespace App\Repository;

use App\Models\Order;

class OrderRepository extends Repository
{
  public function __construct(Order $entity)
  {
    $this->entity = $entity;
  }
}