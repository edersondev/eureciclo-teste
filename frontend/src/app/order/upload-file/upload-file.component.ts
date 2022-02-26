import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-upload-file',
  templateUrl: './upload-file.component.html',
  styleUrls: ['./upload-file.component.css']
})
export class UploadFileComponent implements OnInit {

  hasError:boolean = false;
  file:File | null = null;

  constructor() { }

  ngOnInit(): void {
  }

  eventClickUpload(input:HTMLInputElement) {
    this.hasError = false;
    this.file = null;
    input.click();
  }

  onFileSelected($event:Event) {
    const target:HTMLInputElement = $event.target as HTMLInputElement;
    const files:FileList = target.files as FileList;
    this.file = files.item(0);
    
    if(this.file?.type != "text/plain") {
      this.hasError = true;
    }
  }

}
