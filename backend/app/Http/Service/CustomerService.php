<?php

namespace App\Http\Service;

use App\Http\Services\Service;
use App\Repository\CustomerRepository;

class CustomerService extends Service
{
  public function __construct(CustomerRepository $repository)
  {
    $this->repository = $repository;
  }
}