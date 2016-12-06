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

  calcMonth(month: number, year: number){
    if(month > 11){
      month = month % 11 - 1;
      year = year + 1;
    }
    if(month < 0){
      month = 12 + month;
      year = year - 1;
    }
    return [month, year];
  }

  formatMonth(month: number){
    let my = this.calcMonth(month, 2016);
    let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return months[my[0]];
  }

  changeMonth(month: number, year: number){
    let MonthYear = this.calcMonth(month, year);
    let days = this.calendarService.fetchMonth(MonthYear[0] + 1, MonthYear[1]);
    this.calendarService.displayDays = days;
  }

  ngOnInit() {
  }

}
