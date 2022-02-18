import { Injectable } from '@angular/core';
import {DatePipe} from "@angular/common";

const DATE_DEFAULT = 'dd/MM/yyyy';
const TIME_DEFAULT = 'HH:mm';
const DATE_TIME_DEFAULT = 'dd/MM/yyyy HH:mm';

@Injectable({
  providedIn: 'root'
})
export class DateService {

  constructor(public datepipe: DatePipe) { }

  private formatDateToString(date: Date, format: string): string {
    return this.datepipe.transform(date, format) ?? '';
  }

  formatDate(date: Date){
    return this.formatDateToString(date, DATE_DEFAULT);
  }

  formatTime(date: Date){
    return this.formatDateToString(date, TIME_DEFAULT);
  }

  formatStringToTime(date: string){
    return this.formatDateToString(
      this.formatStringToDateTime(date),
      TIME_DEFAULT
    );
  }

  formatStringToDateTime(date: string){
    let time = date.split(':');
    let newDate = new Date();
    newDate.setHours(Number(time[0]));
    newDate.setMinutes(Number(time[1]));

    return newDate;
  }

  formatDateTime(date: Date){
    return this.formatDateToString(date, DATE_TIME_DEFAULT);
  }
}
