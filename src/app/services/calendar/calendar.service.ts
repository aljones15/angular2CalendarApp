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
  public fetchMonth(month: number, year: number){
    function daysInMonth(m, y) {
      return new Date(y, m, 0).getDate();
    }
   var days = Array.from(new Array(daysInMonth(month, year)), (x , i) => i + 1);
   let FullDays: Day[] = days.map((i) => {
     let dateString = year + "-" + month + "-" + i;
     console.log(dateString);
     return new Day(i , dateString);
     } );
   this.days = FullDays;
   return FullDays;
  }

}
