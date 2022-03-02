<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use Illuminate\Http\Request;
use App\Http\Service\OrderService;

class OrderController extends Controller 
{
  protected $service;

  public function __construct(OrderService $service)
  {
    $this->service = $service;
  }

  public function index(Request $request)
  {
    return new OrderCollection($this->service->index($request));
  }
}