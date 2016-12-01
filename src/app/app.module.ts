import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { AppComponent } from './app.component';
import { CalendarComponent } from './components/calendar/calendar.component';
import { CalendarService } from './services/calendar/calendar.service';
import { BulkEditComponent } from './components/bulk-edit/bulk-edit.component';
import { DayComponent } from './components/day/day.component';


@NgModule({
  declarations: [
    AppComponent,
    CalendarComponent,
    BulkEditComponent,
    DayComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule
  ],
  providers: [CalendarService],
  bootstrap: [AppComponent]
})
export class AppModule {
  constructor(calendarService: CalendarService){
    calendarService.fetchMonth();
    console.log(calendarService);
  }
 }
