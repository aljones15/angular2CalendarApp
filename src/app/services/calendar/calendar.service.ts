import { Injectable } from '@angular/core';
import { Day } from '../../models/day';

@Injectable()
export class CalendarService {
  year: number;
  month: number;
  days: Day[] = [];
  daysInMonth: number = this.days ? this.days.length : 0;
  day: number;
  constructor() {

  }

}
