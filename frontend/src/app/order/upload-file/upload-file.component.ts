import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';

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

  constructor() { }

  ngOnInit(): void {
  }

  eventClickUpload(input:HTMLInputElement) {
    this.hasError = false;
    this.file = null;
    this.hiddenParserResult = true;
    this.inputUpload.reset();
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

}
