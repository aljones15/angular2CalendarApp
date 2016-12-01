import { Directive, OnInit, OnDestroy } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';
import { Day } from '../../models/day';
// http://stackoverflow.com/questions/37971019/angular-2-detect-scroll-event-from-inner-div
// https://toddmotto.com/component-events-event-emitter-output-angular-2

@Directive({
  selector: '[appDay]'
})
export class DayDirective {

  constructor() { }

}
