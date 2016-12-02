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
  update(){
    console.log(this);
    this.errors = [];
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
