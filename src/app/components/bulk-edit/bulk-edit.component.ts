import { Component, OnInit } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';
import { AllOptions, Week, DateRange } from '../../interfaces/interfaces';
import { CalendarError } from '../../models/error';
import { Day } from '../../models/day';

@Component({
  selector: 'app-bulk-edit',
  templateUrl: './bulk-edit.component.html',
  styleUrls: ['./bulk-edit.component.css']
})

export class BulkEditComponent implements OnInit {
  calendarService: CalendarService;
  roomType: string = "single";
  selectDateRange: DateRange;
  all: string;
  week : Week;
  errors: CalendarError[];
  newPrice: number;
  newAvailabilty: number;
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
    this.reset();
    }

  ngOnInit() {
  }

  selectWeekends(){
    this.calendarService.days.map((day) => {
     if(day.day.getDay() >= 5){
       day[this.roomType].selected = true;
     }
    })
  }

  selectWeekdays(){
    this.calendarService.days.map((day) => {
     if(day.day.getDay() < 5){
       day[this.roomType].selected = true;
     }
    })
  }

  deselectAll(){
  this.calendarService.days.map((day) => {
     day.single.selected = false;
     day.double.selected = false;
  })
  }

  select_all(all: string){
    this.deselectAll();
    switch(all){
      case "all_days":
        this.calendarService.days.map((day) => {
          day[this.roomType].selected = true; });
          return;
      case "all_weekends":
        this.selectWeekends();
        return;
      case "all_weekdays":
        this.selectWeekdays();
        return;
      case "all_none":
        this.deselectAll();
        return;
      default:
        return;
    }
  }


  select_day(dayNum: number, roomType: string){
    this.calendarService.days.map((d) => { if(d.day.getDay() == dayNum){
      d[roomType].selected = true;
    } })
  }

  select_days(){
    console.log(this);
    this.select_all(this.all);
    let weekdays = Object.keys(this.week);
    weekdays.map((d) => {
      if(this.week[d]){
        this.select_day(weekdays.indexOf(d), this.roomType);
      }
      if(this.selectDateRange.from && this.selectDateRange.to){
        console.log();
        let from = new Date(this.selectDateRange.from);
        let to = new Date(this.selectDateRange.to);
        this.calendarService.days.map((day) => {
         if(day.day.getTime() >= from.getTime() && day.day.getTime() <= to.getTime()){
           day[this.roomType].selected = true;
         }
        });
      }
    })
  }

  getErrors(section: string): boolean{
    if(!this.errors){
      return false;
    }
    if(this.errors.length <= 0){
      return false;
    }
    let result: boolean = this.errors.reduce((a , b) => { if(b.section == section) { return true } return a; }, false);
    return result;
  }

  validate(){
    if (!this.selectDateRange.from && this.selectDateRange.to || this.selectDateRange.from && !this.selectDateRange.to){
      this.errors.push(new CalendarError("select-from", "Two Dates Required"));
    }
    if (this.selectDateRange.from > this.selectDateRange.to){
      this.errors.push(new CalendarError("select-from", "From is Before To"));
    }
    if(!this.newPrice && !this.newAvailabilty){
      this.errors.push(new CalendarError("change_something", "Please specify a price or a new availability"));
    }
  }

  changeDays(){
    return this.calendarService.days.map((d) => {
      this.changeDay(d, "single");
      this.changeDay(d, "double");
     });
  }

  changeDay(d: Day, roomType: string){
    if(d[roomType].selected){
      if(this.newPrice){
        d[roomType].price = this.newPrice;
      }
      if(this.newAvailabilty){
        d[roomType].available = this.newAvailabilty;
      }
    }
  }

  updateServer(new_days: Day[]){
    let existing_days = new_days.filter((d) => { if(d.id && d.id > 0){ return d; } });
    let create_days = new_days.filter((d) => { if(!d.id || d.id <= 0){ return d; } });
    if(existing_days.length > 0){
      this.calendarService.updateDays(existing_days);
    }
    if(create_days.length > 0){
      this.calendarService.createDays(create_days);
    }

  }

  update(){
    this.errors = [];
    this.validate();
    if(this.errors.length <= 0){
      this.changeDays();
      this.updateServer(this.calendarService.days);
    }
  }
  reset(){
    this.all = null;
    this.week = {
      sunday: false,
      monday: false,
      tuesday: false,
      wednesday: false,
      thursday: false,
      friday: false,
      saturday: false
    };
    this.selectDateRange = {
      from: null,
      to: null
    }
    this.newPrice = null;
    this.newAvailabilty = null;
    this.errors = [];
    this.deselectAll();
  }

}
