import { Room } from './room.ts';

export class Day {
  public id: number;
  public day: Date;
  public single: Room;
  public double: Room;
  constructor(id: number, day: string){
    this.id = id;
    this.day = new Date(day);
    this.single = new Room(10 * id, 2, "single");
    this.double = new Room(20 * id, 2, "double");
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
