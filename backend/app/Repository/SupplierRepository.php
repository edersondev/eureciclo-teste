<?php

namespace App\Repository;

use App\Models\Supplier;

class SupplierRepository
{
  protected $entity;

  public function __construct(Supplier $entity)
  {
    $this->entity = $entity;
  }
}