<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Service\SyncOrderService;

class SyncOrderController extends Controller
{
  protected $service;

  public function __construct(SyncOrderService $service)
  {
    $this->service = $service;
  }

  public function syncData(Request $request) {
    $request->validate([
      'ordercsv' => 'required|file|mimetypes:text/plain'
    ]);
    return response()->json($this->service->syncData($request));
  }
}
