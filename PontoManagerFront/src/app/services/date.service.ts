import { Injectable } from '@angular/core';
import {DatePipe} from "@angular/common";

const SERVER_DATE_FORMAT = 'yyyy-MM-dd'
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

  formatDateToServer(date: Date){
    return this.formatDateToString(date, SERVER_DATE_FORMAT);
  }

  formatServerDateTimeToDate(dateTime: string){
    let [date, hours] = dateTime.split(" ");
    let [year, month, day] = date.split("-");
    let [hour, min] = hours.split(":");
    let newDate = new Date();
    newDate.setFullYear(Number(year), Number(month)-1, Number(day));
    newDate.setHours(Number(hour), Number(min));
    return newDate;
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
