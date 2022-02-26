import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { ProccessDataModel } from '../model/proccess-data.model';

@Component({
  selector: 'app-upload-file',
  templateUrl: './upload-file.component.html',
  styleUrls: ['./upload-file.component.css']
})
export class UploadFileComponent implements OnInit {

  hasError:boolean = false;
  file:File | null = null;
  hiddenParserResult:boolean = true;
  inputUpload:FormControl = new FormControl(null);
  proccessData:ProccessDataModel = {status:false,message:""};

  constructor() { }

  ngOnInit(): void {
  }

  eventClickUpload(input:HTMLInputElement) {
    this.hasError = false;
    this.file = null;
    this.hiddenParserResult = true;
    this.inputUpload.reset();
    this.proccessData = {status:false,message:""};
    input.click();
  }

  onFileSelected($event:Event) {
    const target:HTMLInputElement = $event.target as HTMLInputElement;
    const files:FileList = target.files as FileList;
    this.file = files.item(0);
    
    if(this.file?.type != "text/plain") {
      this.hasError = true;
    } else {
      this.hiddenParserResult = false;
    }
  }

  getProccessData($event:ProccessDataModel): void {
    this.proccessData = $event;
  }

}
