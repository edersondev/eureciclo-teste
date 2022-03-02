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

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function index($request)
  {
    $per_page = ($request->has('per_page') ? $request->per_page : 10);
    if($per_page > 100) {$per_page = 100;}
    return $this->repository->index($request)->paginate($per_page);
  }
}