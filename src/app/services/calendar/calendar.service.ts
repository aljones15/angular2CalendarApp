import { Injectable } from '@angular/core';
import { Day } from '../../models/day';

@Injectable()
export class CalendarService {
  public year: number;
  public month: number;
  public days: Day[] = [];
  public displayDays: Day[];
  public daysInMonth: number = this.days ? this.days.length : 0;
  constructor() {
    this.year = 1979;
  }
  public fetchMonth(){
   let days = Array.from(new Array(31), (x , i) => i + 1);
   this.days = days.map((i) => new Day(i , "2016-12-0" + i) );
  }

}
