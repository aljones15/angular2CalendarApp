import { Component, OnInit } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';
import { AllOptions, Week, DateRange } from '../../interfaces/interfaces';
import { CalendarError } from '../../models/error';

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

  select_day(){
    
  }

  select_days(){
    console.log(this);
    this.select_all(this.all);
  }

  getErrors(section: string): boolean{
    if(!this.errors){
      return false;
    }
    if(this.errors.length <= 0){
      return false;
    }
    let result: boolean = this.errors.reduce((a , b) => { return b.section == section }, false);
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
  update(){
    this.errors = [];
    this.validate();
    console.log(this);
    if(this.errors.length <= 0){

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
  }

}
