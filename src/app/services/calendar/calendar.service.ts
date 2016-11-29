import { Injectable } from '@angular/core';
import { Day } from '../../models/day';

@Injectable()
export class CalendarService {
  year: number;
  month: number;
  daysInMonth: number;
  day: number;
  days: Day[];
  constructor() {

  }

}
