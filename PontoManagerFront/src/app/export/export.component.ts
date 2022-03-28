import {Component, OnInit, ViewChild} from '@angular/core';
import {NoteTime} from "./models/NoteTime";
import {DateService} from "../services/date.service";
import {NoteTimeResponseMapper} from "../home/models/NoteTimeResponseMapper";
import {NoteTimeService} from "../services/note-time.service";
import {MatTable} from "@angular/material/table";
import {DialogService} from "../services/dialog.service";

@Component({
  selector: 'app-export',
  templateUrl: './export.component.html',
  styleUrls: ['./export.component.sass']
})
export class ExportComponent implements OnInit {
  startAt = new Date();
  endAt: Date;
  isLoad = false;
  dataSource: NoteTime[] = [];
  displayedColumns: string[] = ['id_vsts', 'id_task', 'date', 'start_at', 'end_at', 'interval', 'description'];

  @ViewChild(MatTable) table!: MatTable<NoteTime>;

  constructor(
    public dateService: DateService,
    private noteTimeService: NoteTimeService,
    private dialogService: DialogService,
    ) {
    this.endAt = new Date();
    this.endAt = this.addMonthDate(this.endAt);
  }

  ngOnInit(): void {
  }

  generateExcel(){
    this.noteTimeService.generateExcel(
      this.startAt,
      this.endAt,
      (data: any) => {
        let fileName = 'Lançamentos-'+this.dateService.formatDateToServer(this.startAt)+" a "+this.dateService.formatDateToServer(this.endAt)+".xlsx";
        let a = document.createElement('a');
        a.download = fileName;
        a.href = window.URL.createObjectURL(data);
        a.click();
      },
      (error: any) => {
        this.dialogService.open('Erro', error.message);
      }
    );
  }

  loadScreen(){
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
            description: noteTimeResponse.description
          };
          this.calcInterval(note);
          this.newTableRow(note);
        })
        this.isLoad = true;
      },
      (error: any) => {
        this.dialogService.open('Erro', error.message);
      }
    );
  }
  newTableRow(note: NoteTime) {
    this.dataSource.push(note);
  }

  calcInterval(note: NoteTime) {
    let hours = note.end_at.getHours() - note.start_at.getHours();
    let minutes = note.end_at.getMinutes() - note.start_at.getMinutes();
    let result = new Date();
    result.setHours(hours, minutes);
    note.interval = result;
  }

  addMonthDate(date: Date){
    let newDate = new Date(date);
    newDate.setMonth(newDate.getMonth()+1);
    return newDate;
  }
}
