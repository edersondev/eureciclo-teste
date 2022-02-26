import { Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { Papa } from 'ngx-papaparse';

@Component({
  selector: 'app-csv-parser',
  templateUrl: './csv-parser.component.html',
  styleUrls: ['./csv-parser.component.css']
})
export class CsvParserComponent implements OnInit, OnChanges {

  @Input() fileToParser:File | null = null;

  displayedColumns: string[] = [];
  dataSource:MatTableDataSource<any> = new MatTableDataSource();

  constructor(private papa: Papa) { }

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

}
