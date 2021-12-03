import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { InvitationComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';
// Authors: Eric Sakmyster and Merron Tecleab
@NgModule({
  declarations: [
    InvitationComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
  ],
  providers: [],
  bootstrap: [InvitationComponent]
})
export class AppModule { }
