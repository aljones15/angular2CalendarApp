import { Injectable } from '@angular/core';
import { Day } from '../../models/day';

@Injectable()
export class CalendarService {
  public year: number;
  public month: number;
  public days: Day[] = [];
  public daysInMonth: number = this.days ? this.days.length : 0;
  constructor() {
    this.year = 1979;
  }
  public fetchMonth(){

  }

}
