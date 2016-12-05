import { Room } from './room.ts';

export class Day {
  public id?: number;
  public day: Date;
  public single: Room;
  public double: Room;
  constructor(id: number, day: any, singlePrice: number, singleAvailable: number, doublePrice: number, doubleAvailable: number){
    this.id = id;
    this.day = new Date(day);
    this.single = new Room(singlePrice, singleAvailable, "single");
    this.double = new Room(doublePrice, doubleAvailable, "double");
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
