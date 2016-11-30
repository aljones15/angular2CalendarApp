export class Room {
  public price: number;
  public selected: boolean;
  public available: number;
  public type: string;
  constructor(p: number, a: number, t: string){
    this.selected = false;
    this.price = p;
    this.available = a;
    this.type = t;
  }
}
