import { Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { Papa } from 'ngx-papaparse';
import { ProccessDataModel } from '../model/proccess-data.model';
import { OrderService } from '../service/order.service';

@Component({
  selector: 'app-csv-parser',
  templateUrl: './csv-parser.component.html',
  styleUrls: ['./csv-parser.component.css']
})
export class CsvParserComponent implements OnInit, OnChanges {

  @Input() fileToParser:File | null = null;
  @Output() successProccessData: EventEmitter<ProccessDataModel> = new EventEmitter();

  displayedColumns: string[] = [];
  dataSource:MatTableDataSource<any> = new MatTableDataSource();

  constructor(
    private papa: Papa,
    private _orderService: OrderService
  ) { }

  ngOnChanges(changes: SimpleChanges): void {
    const file:File | null = changes['fileToParser'].currentValue;
    if(file != null) {
      this.papa.parse(file,{
        complete: (result) => {
          const dataParse:Array<any> = result.data;
          this.displayedColumns = dataParse.shift();
          this.dataSource.data = dataParse.filter((row:Array<any>) => row.length > 1);
        }
      });
    }
  }

  ngOnInit(): void {
    
  }

  processData(): void {
    if(this.fileToParser != null){
      const formData = new FormData();
      formData.append("ordercsv", this.fileToParser);

      this._orderService.syncOrders(formData).subscribe({
        next: (v) => {
          let proccessData:ProccessDataModel = {
            status:true,
            message:"Dados processados com sucesso!",
            counter:{success:v.success,error:v.errors}
          };
          this.successProccessData.emit(proccessData)
        },
        error: (e) => this.successProccessData.emit({status:false,message:"Erro ao processar dados!"})
      });
    }
  }

}
