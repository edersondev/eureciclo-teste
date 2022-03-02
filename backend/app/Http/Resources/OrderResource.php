<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  { 
    return [
      'id' => $this->id,
      'customer_name' => $this->customer->name,
      'supplier_name' => $this->supplier->name,
      'description' => $this->description,
      'unit_price' => $this->unit_price,
      'quantity' => $this->quantity,
      'address' => $this->address,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
