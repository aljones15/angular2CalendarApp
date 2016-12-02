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
  displayDays: Day[];
  weekly: boolean;
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
    this.displayDays = calendarService.days;
  }
  toggleWeekly(weekly: boolean){
    if(weekly){
    if(this.displayDays.length > 7){
      this.displayDays = this.calendarService.days.slice(0,7);
     }
    } else {
      this.displayDays = this.calendarService.days;
    }
  }

  ngOnInit() {
  }

}
