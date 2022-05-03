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

    protected $_customerService;
    protected $_supplierService;
    protected $_orderService;

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
