<?php

namespace App\Http\Service;

class SyncOrderService
{

  /**
   * @param Illuminate\Http\Request $request
   */
  public function syncData($request)
  {
    $path = $request->file('ordercsv')->store('sync_orders');
  }

}