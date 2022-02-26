import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SyncComponent } from './sync/sync.component';
import { MatIconModule } from '@angular/material/icon';
import { UploadFileComponent } from './upload-file/upload-file.component';
import { MatButtonModule } from '@angular/material/button';
import { FlexLayoutModule } from '@angular/flex-layout';
import { CsvParserComponent } from './csv-parser/csv-parser.component';
import { ReactiveFormsModule } from '@angular/forms';
import { MatTableModule } from '@angular/material/table';

const routes:Routes = [
  {
    path: '',
    component: SyncComponent
  }
];

@NgModule({
  declarations: [
    SyncComponent,
    UploadFileComponent,
    CsvParserComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatButtonModule,
    FlexLayoutModule,
    ReactiveFormsModule,
    MatTableModule
  ]
})
export class OrderModule { }
