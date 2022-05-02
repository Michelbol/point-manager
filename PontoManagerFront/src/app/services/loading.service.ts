import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LoadingService {
  active = false;

  constructor() { }

  show(){
    this.active = true;
  }

  hide(){
    this.active = false;
  }

  isActive(){
    return this.active;
  }
}
