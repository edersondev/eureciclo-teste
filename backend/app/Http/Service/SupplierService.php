<?php

namespace App\Http\Service;

use App\Repository\SupplierRepository;

class SupplierService
{
  protected $repository;

  public function __construct(SupplierRepository $repository)
  {
    $this->repository = $repository;
  }
}