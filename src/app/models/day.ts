import { Room } from './room.ts';

export class Day {
  public id: number;
  public day: Date;
  public single: Room;
  public double: Room;
  constructor(){

  }
}

/*
  database dbo.days
  id int
  day DateTime
  single_price int
  single_available int
  double_price int
  double_available int

  */
