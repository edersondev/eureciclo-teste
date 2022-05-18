<?php

namespace App\Http\Service;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\CsvContentException;

class SyncOrderService
{
  protected $customerService, $supplierService, $orderService;

  public function __construct(
    CustomerService $customerService,
    SupplierService $supplierService,
    OrderService $orderService
  )
  {
    $this->customerService = $customerService;
    $this->supplierService = $supplierService;
    $this->orderService = $orderService;
  }

  /**
   * @param \Illuminate\Http\Request $request
   */
  public function syncData($request)
  {
    $path = $request->file('ordercsv')->store('sync_orders');
    
    $arrayData = $this->convertCsvToArray($path);
    $resultDataStore = $this->storeData($arrayData);
    Storage::delete($path);
    return $resultDataStore;
  }

  public function convertCsvToArray($path)
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

  public function storeData($arrayData)
  {
    $this->validateCsvContent($arrayData);
    $storeCount = ['errors' => 0,'success' => 0];
    foreach($arrayData as $line => $data) {
      try {
        $this->validateRow($line,$data);
        $this->storeOrder($data);
        $storeCount['success']++;
      } catch (\Exception $ex) {
        $storeCount['errors']++;
      }
    }
    return $storeCount;
  }

  public function validateCsvContent($arrayData)
  {
    if(empty($arrayData)) {
      throw new CsvContentException("Arquivo vazio");
    }
    if(is_array($arrayData) && count($arrayData[0]) != 6) {
      throw new CsvContentException("Arquivo com formato inválido");
    }
  }

  public function validateRow($line, $rowData)
  {
    $ruleString = 'required|string|max:255';
    $validator = Validator::make($rowData, [
      'comprador' => $ruleString,
      'descricao' => $ruleString,
      'preco_unitario' => 'required|numeric',
      'quantidade' => 'required|numeric',
      'endereco' => $ruleString,
      'fornecedor' => $ruleString
    ]);

    if ($validator->fails()) {
      $firstError = $validator->errors()->first();
      $lineOnCsvFile = $line + 2;
      throw new CsvContentException("Error on line {$lineOnCsvFile}: {$firstError}");
    }
  }

  private function storeCustomer($data)
  {
    $request = new Request();
    $request->merge(['name' => $data['comprador']]);
    return $this->customerService->store($request);
  }

  private function storeSupplier($data)
  {
    $request = new Request();
    $request->merge(['name' => $data['fornecedor']]);
    return $this->supplierService->store($request);
  }

  public function storeOrder($data)
  {
    $customer = $this->storeCustomer($data);
    $supplier = $this->storeSupplier($data);
    $request = new Request();
    $request->merge(['customer_id' => $customer->id]);
    $request->merge(['supplier_id' => $supplier->id]);
    $request->merge(['description' => $data['descricao']]);
    $request->merge(['unit_price' => $data['preco_unitario']]);
    $request->merge(['quantity' => $data['quantidade']]);
    $request->merge(['address' => $data['endereco']]);
    return $this->orderService->store($request);
  }
}