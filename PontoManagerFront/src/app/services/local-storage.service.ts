import { Injectable } from '@angular/core';
import {StorageEnum} from "../enums/storage.enum";

@Injectable({
  providedIn: 'root'
})
export class LocalStorageService {

  public readonly storage: Storage;

  constructor() {
    this.storage = window.localStorage;
  }

  set(key: StorageEnum, value: string): boolean {
    if(this.storage){
      this.storage.setItem(key, JSON.stringify(value));
    }
    return false;
  }

  get(key: StorageEnum): any{
    if(this.storage){
      const value = this.storage.getItem(key);
      if(value !== null){
        return JSON.parse(value);
      }
    }
    return null;
  }

  remove(key: StorageEnum): boolean{
    if (this.storage) {
      this.storage.removeItem(key);
      return true;
    }
    return false;
  }

  clear(): boolean {
    if (this.storage) {
      this.storage.clear();
      return true;
    }
    return false;
  }
}
