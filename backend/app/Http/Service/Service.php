<?php

namespace App\Http\Service;

class Service
{
  protected $repository;

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function store($request)
  {
    return $this->repository->store($request);
  }
}