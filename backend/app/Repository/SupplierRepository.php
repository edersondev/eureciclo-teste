<?php

namespace App\Repository;

use App\Models\Supplier;

class SupplierRepository extends Repository
{
  public function __construct(Supplier $entity)
  {
    $this->entity = $entity;
  }
}