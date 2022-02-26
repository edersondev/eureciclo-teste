<?php

namespace App\Repository;

use App\Models\Customer;

class CustomerRepository
{
  protected $entity;

  public function __construct(Customer $entity)
  {
    $this->entity = $entity;
  }
}