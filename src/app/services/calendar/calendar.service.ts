import { Injectable, EventEmitter } from '@angular/core';
import { Day } from '../../models/day';
import { ChangeMonth } from '../../models/changeMonth';
import { Http, Response, Headers } from '@angular/http';
import { Observable }     from 'rxjs/Observable';

@Injectable()
export class CalendarService {
  public year: number;
  public month: number;
  public days: Day[] = [];
  public daysInMonth: number = this.days ? this.days.length : 0;
  public firstDay?: Day;
  public lastDay?: Day;
  public loading: boolean;
  public changeMonthEvent$: EventEmitter<ChangeMonth>;
  private baseURL: string =  "http://localhost:8000";
  /*
    "http://localhost:8000"
    "http://hotelquick.nfshost.com/api"
  */
  constructor(private http: Http) {
    this.loading = true;
    this.changeMonthEvent$ = new EventEmitter();
  }

  public makeFakeDays(month: number, year: number, calendar: CalendarService){
    return function(error: Response | any): Day[]{
       let days = calendar.genDays(month, year);
       calendar.setDays(days);
       return days;
     }
  }

  public genDays(month: number, year: number): Day[]{
    function daysInMonth(m, y) {
        return new Date(y, m, 0).getDate();
      }
     var days = Array.from(new Array(daysInMonth(month, year)), (x , i) => i + 1);
     let FullDays: Day[] = days.map((i) => {
       let dayFormat = i < 10 ? "0" + i : i;
       let monthFormat = month < 10 ? "0" + month : month;
       let dateString = year + "-" + monthFormat + "-" + dayFormat + "T13:00:00";
       let new_day = new Day(null, dateString, 100, 3, 200, 3);
       return new_day;
       } );
      return FullDays;
  }

  public setDays(days: Day[]){
    this.days = days;
    this.firstDay = this.days.length > 0 ? this.days.slice(0,1)[0] : null;
    this.lastDay = this.days.length > 0 ? this.days[this.days.length - 1] : null;
    this.loading = false;
    let changeMonth = new ChangeMonth(true);
    this.changeMonthEvent$.emit(changeMonth);
  }

  private extractData(month: number, year: number, calendar: CalendarService){
    return function(res: Response): Day[]{
      let body = JSON.parse(res.json());
      let days = body.map((d) => {
        return new Day(d.id, d.day.timestamp * 1000, parseInt(d.singlePrice),parseInt(d.singleAvailable), parseInt(d.doublePrice), parseInt(d.doubleAvailable));
      })
      if(days.length > 0){
        calendar.setDays(days);
      }
      else{
        days = calendar.genDays(month, year);
        calendar.setDays(days);
      }
      return days;
    }
  }

  getMonth(month: number, year: number): Promise<Day[]>{
    this.loading = true;
    return this.http.get(this.baseURL + "/month/" + month + "/year/" + year)
      .toPromise()
      .then(this.extractData(month, year, this))
      .catch(this.makeFakeDays(month, year, this));
  }

  public updateDays(days: Day[]): Promise<Day[]>{
    let headers = new Headers();
    headers.append('Content-Type', 'application/json');
    let url = this.baseURL + "/updateMonth";
    return this.http.put(url, JSON.stringify(days), { headers: headers })
      .toPromise()
      .then((r: any) => { console.log(r); })
      .catch((e :any) => { console.log(e); })
  }

  public createDays(days: Day[]): Promise<Day[]>{
    let headers = new Headers();
    headers.append('Content-Type', 'application/json');
    let url = this.baseURL + "/createMonth";
    return this.http.post(url, JSON.stringify(days), { headers: headers })
      .toPromise()
      .then((r: any) => { console.log(r); })
      .catch((e :any) => { console.log(e); })
  }

  public fetchMonth(month: number, year: number){
    this.year = year;
    this.month = month;
    let days = this.getMonth(month, year);
    let fakeDays = [];
    this.days = [];
    return fakeDays;
  }


}
