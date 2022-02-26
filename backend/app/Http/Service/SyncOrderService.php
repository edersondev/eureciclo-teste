<?php

namespace App\Http\Service;

use Illuminate\Support\Str;

class SyncOrderService
{

  /**
   * @param Illuminate\Http\Request $request
   */
  public function syncData($request)
  {
    $path = $request->file('ordercsv')->store('sync_orders');
    
    $arrayData = $this->convertCsvToArray($path);

    dd($arrayData);
  }

  private function convertCsvToArray($path)
  {
    $fullPath = storage_path("app/{$path}");
    $arrayFromCsv = array_map(function($v){return str_getcsv($v, "\t");}, file($fullPath));

    $header = array_map(function($v){
      return Str::slug($v,"_");
    },array_shift($arrayFromCsv));

    return array_map(function($v) use ($header){
      return array_combine($header,$v);
    },$arrayFromCsv);

  }
}