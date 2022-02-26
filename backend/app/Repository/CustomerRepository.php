<?php

namespace App\Repository;

use App\Models\Customer;

class CustomerRepository extends Repository
{
  public function __construct(Customer $entity)
  {
    $this->entity = $entity;
  }
}