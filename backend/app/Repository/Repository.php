<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class Repository
{
  protected $entity;

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function store($request)
  {
    return DB::transaction(function () use ($request) {
      $arrInput = $request->only($this->entity->getFillable());
      return $this->entity::firstOrCreate($arrInput);
    });
  }
}