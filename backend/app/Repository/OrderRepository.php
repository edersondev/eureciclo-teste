<?php

namespace App\Repository;

use App\Models\Order;

class OrderRepository extends Repository
{
  public function __construct(Order $entity)
  {
    $this->entity = $entity;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function index($request)
  {
    return $this->entity::orderBy('id','desc');
  }
}