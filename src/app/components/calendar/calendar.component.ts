import { Component, OnInit } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';
import { Day } from '../../models/day';

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.css']
})
export class CalendarComponent implements OnInit {
  calendarService: CalendarService;
  displayDays: Day[];
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
    this.displayDays = calendarService.days;
  }

  ngOnInit() {
  }

}
