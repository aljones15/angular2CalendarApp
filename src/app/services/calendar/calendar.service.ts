import { Injectable } from '@angular/core';
import { Day } from '../../models/day';
import { Http, Response } from '@angular/http';
import { Observable }     from 'rxjs/Observable';

@Injectable()
export class CalendarService {
  public year: number;
  public month: number;
  public days: Day[] = [];
  public displayDays: Day[];
  public daysInMonth: number = this.days ? this.days.length : 0;
  constructor(private http: Http) {
    this.year = 1979;
  }

  public makeFakeDays(month: number, year: number){
    let that = this;
    return function(error: Response | any): Day[]{
       that.setDays(that.genDays(month, year));
       return that.days;
     }
  }

  public genDays(month: number, year: number): Day[]{
    function daysInMonth(m, y) {
        return new Date(y, m, 0).getDate();
      }
     var days = Array.from(new Array(daysInMonth(month, year)), (x , i) => i + 1);
     let FullDays: Day[] = days.map((i) => {
       let dateString = year + "-" + month + "-" + i;
       return new Day(null, dateString, 100, 3, 200, 3);
       } );
      return FullDays;
  }

  public setDays(days: Day[]){
    this.days = days;
    this.displayDays = days;
  }

  private extractData(month: number, year: number){
    let that = this;
    return function(res: Response): Day[]{
      let body = JSON.parse(res.json());
      let days = body.map((d) => {
        return new Day(d.id, d.day.timestamp * 1000, parseInt(d.singlePrice),parseInt(d.singleAvailable), parseInt(d.doublePrice), parseInt(d.doubleAvailable));
      })
      console.log(days);
      if(days.length > 0){
        that.setDays(days);
      }
      else{
        days = that.genDays(month, year);
        that.setDays(days);
      }
      return days;
    }
  }

  getMonth(month: number, year: number): Promise<Day[]>{
    return this.http.get("http://localhost:8000/month/" + month + "/year/" + year)
      .toPromise()
      .then(this.extractData(month, year))
      .catch(this.makeFakeDays(month, year));
  }

  public fetchMonth(month: number, year: number){
    let days = this.getMonth(month, year);
    let fakeDays = [];
    this.displayDays = [];
    this.days = [];
    return fakeDays;
  }


}
