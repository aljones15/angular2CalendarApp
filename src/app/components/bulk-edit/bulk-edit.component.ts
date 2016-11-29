import { Component, OnInit } from '@angular/core';
import { CalendarService } from '../../services/calendar/calendar.service';


@Component({
  selector: 'app-bulk-edit',
  templateUrl: './bulk-edit.component.html',
  styleUrls: ['./bulk-edit.component.css']
})
export class BulkEditComponent implements OnInit {
  calendarService: CalendarService;
  constructor(calendarService: CalendarService) {
    this.calendarService = calendarService;
    }
  ngOnInit() {
  }

}
