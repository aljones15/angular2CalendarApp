export class CalendarError {
  section: string;
  message: string;
  constructor(s: string, m: string){
    this.section = s;
    this.message = m;
  }
}
