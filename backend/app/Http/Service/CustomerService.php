<?php

namespace App\Http\Service;

use App\Repository\CustomerRepository;

class CustomerService
{
  protected $repository;

  public function __construct(CustomerRepository $repository)
  {
    $this->repository = $repository;
  }
}