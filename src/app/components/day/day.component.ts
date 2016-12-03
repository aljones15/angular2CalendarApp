import { Component, OnInit, OnDestroy, Input } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';
import { Day } from '../../models/day';
// http://stackoverflow.com/questions/37971019/angular-2-detect-scroll-event-from-inner-div
// https://toddmotto.com/component-events-event-emitter-output-angular-2
@Component({
  selector: 'app-day',
  templateUrl: './day.component.html',
  styleUrls: ['./day.component.css']
})
export class DayComponent implements OnInit {
  @Input() day: Day;
  @Input() weekly: boolean;
  calendarService: CalendarService;

  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
  }

  ngOnInit() {
  }
  OnDestroy(){
  }

  getDayString(i: number){
    let days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    return days[i];
  }

}
