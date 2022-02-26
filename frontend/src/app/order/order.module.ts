import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SyncComponent } from './sync/sync.component';
import { MatIconModule } from '@angular/material/icon';
import { UploadFileComponent } from './upload-file/upload-file.component';
import { MatButtonModule } from '@angular/material/button';
import { FlexLayoutModule } from '@angular/flex-layout';

const routes:Routes = [
  {
    path: '',
    component: SyncComponent
  }
];

@NgModule({
  declarations: [
    SyncComponent,
    UploadFileComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatButtonModule,
    FlexLayoutModule
  ]
})
export class OrderModule { }
