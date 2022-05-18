<?php

namespace Tests\Unit\App\Http\Service;

use App\Http\Service\SyncOrderService;
use App\Http\Service\CustomerService;
use App\Http\Service\SupplierService;
use App\Http\Service\OrderService;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Exceptions\CsvContentException;

use Tests\TestCase;

class SyncOrderServiceTest extends TestCase
{
    protected $_service;

    /**
     * @var \App\Http\Service\CustomerService&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $_customerService;

    /**
     * @var \App\Http\Service\SupplierService&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $_supplierService;

    /**
     * @var \App\Http\Service\OrderService&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $_orderService;

    protected $_dumpData = [
        'comprador' => 'João Silva',
        'descricao' => 'R$10 off R$20 of food',
        'preco_unitario' => 10.0,
        'quantidade' => 2,
        'endereco' => '987 Fake St',
        'fornecedor' => 'Bob\'s pizza'
    ];

    public function setUp(): void
    {
        $this->_customerService = $this->createMock(CustomerService::class);
        $this->_supplierService = $this->createMock(SupplierService::class);
        $this->_orderService = $this->createMock(OrderService::class);
        
        $this->_service = new SyncOrderService(
            $this->_customerService,
            $this->_supplierService,
            $this->_orderService
        );

        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function whenConvertDataFileToArraySuccess()
    {
        Storage::fake('csvfiles');

        $path = UploadedFile::fake()->createWithContent('test.csv',$this->fakeCsvContent())->store('sync_orders');
        
        $arrData = $this->_service->convertCsvToArray($path);
        $this->assertNotEmpty($arrData);

        $keys = ['comprador','descricao','preco_unitario','quantidade','endereco','fornecedor'];
        foreach($arrData as $data) {
            $this->assertEquals($keys,array_keys($data));
        }
    }

    /**
     * @test
     * @dataProvider validateCsvContentDataProvider
     * @return void
     */
    public function whenValidateCsvContent($exceptionMessage,$arrData)
    {
        $this->expectException(CsvContentException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $this->_service->validateCsvContent($arrData);
    }

    /**
     * @test
     * @return void
     */
    public function whenValidateRowFailsThenReturnException()
    {
        $this->dumbData['comprador'] = '';

        $this->expectException(CsvContentException::class);

        $this->_service->validateRow(1,$this->dumbData);
    }

    /**
     * @test
     * @return void
     */
    public function whenStoreOrderThenReturnSuccess()
    {
        $customer = new \App\Models\Customer();
        $customer->id = 1;
        $customer->name = $this->_dumpData['comprador'];
        $this->_customerService->method('store')->willReturn($customer);

        $supplier = new \App\Models\Supplier();
        $supplier->id = 1;
        $supplier->name = $this->_dumpData['fornecedor'];
        $this->_supplierService->method('store')->willReturn($supplier);

        $order = new \App\Models\Order();
        $order->id = 1;
        $order->customer_id = $customer->id;
        $order->supplier_id = $supplier->id;
        $order->description = $this->_dumpData['descricao'];
        $order->unit_price = $this->_dumpData['preco_unitario'];
        $order->quantity = $this->_dumpData['quantidade'];
        $order->address = $this->_dumpData['endereco'];

        $this->_orderService->method('store')->willReturn($order);

        $result = $this->_service->storeOrder($this->_dumpData);

        $expectResult = [
            "id" => 1,
            "customer_id" => 1,
            "supplier_id" => 1,
            "description" => "R$10 off R$20 of food",
            "unit_price" => 10.0,
            "quantity" => 2,
            "address" => "987 Fake St"
        ];

        $this->assertNotEmpty($result);
        $this->assertInstanceOf(\App\Models\Customer::class,$customer);
        $this->assertInstanceOf(\App\Models\Supplier::class,$supplier);
        $this->assertInstanceOf(\App\Models\Order::class,$result);
        $this->assertEquals($expectResult,$result->toArray());
    }

    /**
     * @return array
     */
    public function validateCsvContentDataProvider()
    {
        $fakeData = [
            ['col1' => 'value1']
        ];
        return [
            'when File Is Empty' => ["Arquivo vazio",[]],
            'when File Format Is Wrong' => ["Arquivo com formato inválido",$fakeData]
        ];
    }

    private function fakeCsvContent()
    {
        $contentCsv = [
            ['Comprador','Descrição','Preço Unitário','Quantidade','Endereço','Fornecedor'],
            ['João Silva','R$10 off R$20 of food',10.0,2,'987 Fake St','Bob\'s pizza'],
            ['Amy Pond','R$30 of awesome for R$10',10.0,5,'456 Unreal Rd','Tom\'s Awesome Shop']
        ];
        $fp = fopen('php://memory', 'r+b');
        $data = "";
        foreach($contentCsv as $content){
            fputcsv($fp, $content, "\t", '"');
            rewind($fp);
            $data = rtrim(stream_get_contents($fp), "\n");
        }
        fclose($fp);
        return $data;
    }
}
