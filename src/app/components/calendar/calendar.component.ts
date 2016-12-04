import { Component, OnInit } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';
import { Day } from '../../models/day';
import { DayComponent } from '../day/day.component';

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.css']
})
export class CalendarComponent implements OnInit {
  calendarService: CalendarService;
  weekly: boolean;
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
    this.calendarService.displayDays = calendarService.days;
  }
  toggleWeekly(weekly: boolean){
    this.weekly = weekly;
  }

  formatMonth(month: number){
    if(month > 11){
      console.error("incorrect month index");
      month = month % 11;
    }
    let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return months[month];
  }

  ngOnInit() {
  }

}
