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
  all: AllOptions;
  week : Week;
  errors: CalendarError[];
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
    this.reset();
    }

  ngOnInit() {
  }

  selectWeekends(){
    console.log(this.roomType);
    this.calendarService.days.map((day) => {
     if(day.day.getDay() >= 5){
       day[this.roomType].selected = true;
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
  }
  update(){
    this.errors = [];
    this.validate();
    console.log(this);
  }
  reset(){
    this.all = {
      days: false,
      weekdays: false,
      weekends: false
    };
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
    this.errors = [];
  }

}
