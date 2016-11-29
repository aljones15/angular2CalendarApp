import { Component, OnInit } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.css']
})
export class CalendarComponent implements OnInit {
  calendarService: CalendarService;
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
  }

  ngOnInit() {
  }

}
