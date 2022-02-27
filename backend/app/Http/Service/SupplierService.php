<?php

namespace App\Http\Service;

use App\Repository\SupplierRepository;

class SupplierService extends Service
{
  public function __construct(SupplierRepository $repository)
  {
    $this->repository = $repository;
  }
}