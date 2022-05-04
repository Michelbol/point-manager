import {Component, OnInit} from '@angular/core';
import {NoteTimeResponseMapper} from "../home/models/NoteTimeResponseMapper";
import {NoteTime} from "./models/NoteTime";
import {LoadingService} from "../services/loading.service";
import {NoteTimeService} from "../services/note-time.service";
import {DateService} from "../services/date.service";
import {DialogService} from "../services/dialog.service";
import {CodeAreaEnum} from "../enums/codeArea.enum";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.sass']
})
export class DashboardComponent implements OnInit {
  referenceDate: Date = new Date();
  startAt = new Date();
  endAt: Date = new Date();
  dataSource: NoteTime[] = [];
  isLoad = false;
  notBillablePercent = 0;
  displayedColumns: string[] = ['id_vsts', 'id_task', 'date', 'start_at', 'end_at', 'interval', 'description', 'estimated_time'];
  totalHoursTask: string = '00:00';
  totalHoursVsts: string = '00:00';
  totalEmptyHours: string = '00:00';
  totalIdleHours: string = '00:00';

  constructor(private noteTimeService: NoteTimeService,
              private loading: LoadingService,
              public dateService: DateService,
              private dialogService: DialogService,
  ) {
    this.endAt.setDate(1);
    this.endAt = this.addMonthDate(this.endAt);
    this.referenceDate.setHours(0, 0, 0, 0);
    this.startAt.setDate(1);
  }

  ngOnInit(): void {
  }

  loadScreen(){
    this.loading.show();
    this.noteTimeService.listTaskByDate(
      this.startAt,
      this.endAt,
      (data: Array<NoteTimeResponseMapper>) => {
        this.dataSource = [];
        data.map((noteTimeResponse) => {
          let startAt: Date = noteTimeResponse.start_at === null ? new Date() : this.dateService.formatServerDateTimeToDate(noteTimeResponse.start_at);
          let endAt: Date = noteTimeResponse.end_at === null ? new Date() : this.dateService.formatServerDateTimeToDate(noteTimeResponse.end_at);
          let note: NoteTime = {
            id: noteTimeResponse.id,
            id_vsts: noteTimeResponse.id_vsts,
            id_task: noteTimeResponse.id_task,
            date: startAt,
            start_at: startAt,
            end_at: endAt,
            interval: new Date(),
            description: noteTimeResponse.description,
            task: {
              idTaskType: noteTimeResponse.task.idTaskType,
              estimatedTime: noteTimeResponse.task.estimatedTime,
              codeArea: noteTimeResponse.task.codeArea
            },
            isIdle() {
              return this.id_task != 0 && this.id_vsts != 0 && this.task.codeArea == CodeAreaEnum.billable && this.task.idTaskType == 99;
            }
          };
          note.interval = this.dateService.calcInterval(note.start_at, note.end_at);
          this.newTableRow(note);
        })

        let vstsHours = this.calcTotalIntervalVsts();
        let taskHours = this.calcTotalIntervalTask();
        let emptyHours = this.calcTotalIntervalEmpty();
        let idleHours = this.calcTotalIntervalIdle();
        let diffInMinutesTask = this.calcDifInMinutes(this.referenceDate, taskHours)
        let diffInMinutesVsts = this.calcDifInMinutes(this.referenceDate, vstsHours)
        let diffInMinutesEmpty = this.calcDifInMinutes(this.referenceDate, emptyHours)
        let diffInMinutesIdle = this.calcDifInMinutes(this.referenceDate, idleHours)

        let percent = (diffInMinutesTask-diffInMinutesVsts)/diffInMinutesTask;
        this.notBillablePercent = Number(((percent)*100).toFixed(2));
        this.totalHoursTask = this.dateTimeExhibition(diffInMinutesTask);
        this.totalHoursVsts = this.dateTimeExhibition(diffInMinutesVsts);
        this.totalEmptyHours = this.dateTimeExhibition(diffInMinutesEmpty);
        this.totalIdleHours = this.dateTimeExhibition(diffInMinutesIdle);

        this.loading.hide();
        this.isLoad = true;
      },
      (error: any) => {
        this.loading.hide();
        this.dialogService.open('Erro', error.message);
      }
    );
  }

  dateTimeExhibition(minutes: number){
    const totalHours = Math.round(minutes/60);
    const totalMinutes = minutes - totalHours*60;
    return `${Math.abs(totalHours)}:${Math.abs(totalMinutes)}`;
  }

  calcDifInMinutes(date1: Date, date2: Date){
    const diffMilliseconds = date2.valueOf() - date1.valueOf();
    const diffSeconds = diffMilliseconds / 1000;
    const diffMinutes = diffSeconds / 60;
    return Math.round(diffMinutes);
  }

  addMonthDate(date: Date){
    let newDate = new Date(date);
    newDate.setMonth(newDate.getMonth()+1);
    newDate.setDate(newDate.getDate()-1);
    return newDate;
  }

  newTableRow(note: NoteTime) {
    this.dataSource.push(note);
  }

  calcTotalIntervalBase(callbackReduce: any){
    let totalHours = new Date();
    totalHours.setHours(0, 0, 0, 0);
    totalHours = this.dataSource.reduce(callbackReduce, totalHours)
    return totalHours;
  }

  callbackTotalInterval(sum: Date, item: NoteTime) {
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  callbackVstsTotal(sum: Date, item: NoteTime) {
    if(item.id_vsts == 0){
      return sum;
    }
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  callbackTaskTotal(sum: Date, item: NoteTime) {
    if(item.id_task == 0){
      return sum;
    }
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  callbackEmptyTotal(sum: Date, item: NoteTime) {
    if(item.id_task != 0 && item.id_vsts != 0){
      return sum;
    }
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  callbackIdleTotal(sum: Date, item: NoteTime) {
    if(!item.isIdle()){
      return sum;
    }
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  calcTotalIntervalVsts() {
    return this.calcTotalIntervalBase(this.callbackVstsTotal);
  }

  calcTotalIntervalEmpty() {
    return this.calcTotalIntervalBase(this.callbackEmptyTotal);
  }

  calcTotalIntervalTask() {
    return this.calcTotalIntervalBase(this.callbackTaskTotal);
  }

  calcTotalIntervalIdle() {
    return this.calcTotalIntervalBase(this.callbackIdleTotal);
  }

}
