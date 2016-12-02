export interface AllOptions {
  days: boolean;
  weekdays: boolean;
  weekends: boolean;
}
export interface Week {
  sunday: boolean;
  monday: boolean;
  tuesday: boolean;
  wednesday: boolean;
  thursday: boolean;
  friday: boolean;
  saturday: boolean;
}

export interface DateRange {
  from?: Date;
  to?: Date;
}
