import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SyncComponent } from './sync/sync.component';

const routes:Routes = [
  {
    path: '',
    component: SyncComponent
  }
];

@NgModule({
  declarations: [
    SyncComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ]
})
export class OrderModule { }
