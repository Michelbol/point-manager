import {Component, OnInit, ViewChild} from '@angular/core';
import {DateService} from '../services/date.service';
import {MatTable} from "@angular/material/table";
import {SelectionModel} from "@angular/cdk/collections";
import {NoteTime} from "./models/NoteTime";
import {NoteTimeFactory} from "./models/NoteTimeFactory";
import {NoteTimeService} from "../services/note-time.service";
import {DialogService} from "../services/dialog.service";
import {NoteTimeResponseMapper} from "./models/NoteTimeResponseMapper";
import {LoadingService} from "../services/loading.service";
import {EditableFieldTime} from "./models/EditableFieldTime";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.sass']
})
export class HomeComponent implements OnInit {
  dataSource: NoteTime[] = [];
  displayedColumns: string[] = ['select', 'id_vsts', 'id_task', 'date', 'start_at', 'end_at', 'interval', 'description'];
  selection = new SelectionModel<NoteTime>(true, []);
  oldValue: any;
  actualDates = new Date();
  modalData: NoteTime;
  modalInterval: string;
  modalOpen = false;

  @ViewChild(MatTable) table!: MatTable<NoteTime>;

  constructor(
    public dateService: DateService,
    private noteTimeFactory: NoteTimeFactory,
    private noteTimeService: NoteTimeService,
    private dialogService: DialogService,
    private loading: LoadingService
  ) {
    this.modalData = this.noteTimeFactory.create(this.dataSource.length, this.actualDates);
    this.modalInterval = "00:00";
  }

  ngOnInit(): void {
    this.loadMyTasks();
  }

  addRow(note: NoteTime) {
    this.dataSource.push(note);
    this.table.renderRows();
  }

  newEditableFieldNumber(number: number) {
    return {
      value: number,
      editable: false
    }
  }

  newEditableFieldText(text: string|null) {
    return {
      value: text,
      editable: false
    }
  }

  newEditableFieldDate(date: Date) {
    return {
      value: date,
      editable: false
    };
  }

  newEditableFieldTime(date: Date) {
    return {
      string: this.dateService.formatTime(date),
      value: date,
      editable: false
    };
  }

  changeActualDates(){
    this.loadMyTasks();
  }

  loadMyTasks() {
    this.loading.show();
    this.noteTimeService.myTasks(
      this.actualDates,
      (data: Array<NoteTimeResponseMapper>) => {
        this.dataSource = [];
        data.map((noteTimeResponse) => {
          let startAt: Date = noteTimeResponse.start_at === null ? new Date() : this.dateService.formatServerDateTimeToDate(noteTimeResponse.start_at);
          let endAt: Date = noteTimeResponse.end_at === null ? new Date() : this.dateService.formatServerDateTimeToDate(noteTimeResponse.end_at);
          let note: NoteTime = {
            id: noteTimeResponse.id,
            id_vsts: this.newEditableFieldNumber(noteTimeResponse.id_vsts),
            id_task: this.newEditableFieldNumber(noteTimeResponse.id_task),
            date: this.newEditableFieldDate(startAt),
            start_at: this.newEditableFieldTime(startAt),
            end_at: this.newEditableFieldTime(endAt),
            interval: new Date(),
            description: this.newEditableFieldText(noteTimeResponse.description)
          };
          this.calcInterval(note);
          this.newTableRow(note);
        })
        this.loading.hide();
      },
      (error: any) => {
        this.loading.hide();
        this.dialogService.open('Erro', error.message);
      }
    );
  }

  openModalNewDateTime(){
    this.modalData = this.noteTimeFactory.create(this.dataSource.length, this.actualDates);
    let lastNoteTime = this.getLastNoteTime();
    if(lastNoteTime != undefined){
      this.modalData.start_at.string = lastNoteTime.end_at.string;
      this.modalData.start_at.value = this.dateService.formatStringToDateTime(lastNoteTime.end_at.string);
      this.modalData.end_at.string = lastNoteTime.end_at.string;
      this.modalData.end_at.value = this.dateService.formatStringToDateTime(lastNoteTime.end_at.string);
    }
    this.calcIntervalModal();
    this.openModal();
  }

  getLastNoteTime(){
    return this.dataSource[this.dataSource.length-1];
  }

  closeModal(){
    this.modalOpen = false;
  }

  openModal(){
    this.modalOpen = true;
  }

  saveNewDateTime(){
    this.loading.show();
    this.noteTimeService.saveNoteTime(
      this.modalData,
      ({data}: any, note: NoteTime) => {
        note.id = data.id;
        this.newTableRow(note);
        this.loading.hide();
        this.closeModal();
      },
      ({error}: any) => {
        this.loading.hide();
        this.dialogService.open('Erro', error.message);
      });
  }

  updateDate(date: EditableFieldTime){
    date.value = this.dateService.formatStringToDateTime(date.string);
    this.calcIntervalModal();
  }

  newRow() {
    this.loading.show();
    let note = this.noteTimeFactory.create(this.dataSource.length, this.actualDates);
    this.calcInterval(note);
    this.noteTimeService.saveNoteTime(
      note,
      ({data}: any, note: NoteTime) => {
        note.id = data.id;
        this.newTableRow(note);
        this.loading.hide();
      },
      ({error}: any) => {
        this.loading.hide();
        this.dialogService.open('Erro', error.message);
      });
  }

  newTableRow(note: NoteTime) {
    this.addRow(note);
    this.table.renderRows();
  }

  removeSelectRows() {
    if(this.selection.selected.length === 0){
      return;
    }
    this.loading.show();
    this
      .noteTimeService
      .deleteMany(
        this.selection.selected,
        () => {
          for (let index in this.selection.selected) {
            this.removeDataSourceById(this.selection.selected[index].id)
          }
          this.selection.clear();
          this.table.renderRows();
          this.loading.hide();
        },
        ({error}: any) => {
          this.loading.hide();
          this.dialogService.open('Erro', error.message);
        });
  }

  removeDataSourceById(id: number) {
    for (const noteTime in this.dataSource) {
      if (this.dataSource[noteTime].id === id) {
        this.dataSource.splice(Number(noteTime), 1);
      }
    }
  }

  isAllSelected() {
    const numSelected = this.selection.selected.length;
    const numRows = this.dataSource.length;
    return numSelected === numRows;
  }

  masterToggle() {
    if (this.isAllSelected()) {
      this.selection.clear();
      return;
    }

    this.selection.select(...this.dataSource);
  }

  checkboxLabel(row?: NoteTime): string {
    if (!row) {
      return `${this.isAllSelected() ? 'deselect' : 'select'} all`;
    }
    return `${this.selection.isSelected(row) ? 'deselect' : 'select'} row ${row.id + 1}`;
  }

  closeOthersInputs() {
    this.dataSource.map((item) => {
      if (item.id_vsts.editable) {
        this.cancelInput(item.id_vsts);
      }
      if (item.id_task.editable) {
        this.cancelInput(item.id_task);
      }
      if (item.date.editable) {
        this.cancelInput(item.date);
      }
      if (item.start_at.editable) {
        this.cancelInput(item.start_at);
      }
      if (item.end_at.editable) {
        this.cancelInput(item.end_at);
      }
    })
  }

  showInput(item: any) {
    this.closeOthersInputs();
    this.oldValue = item.value;
    item.editable = true;
  }

  cancelInput(item: any) {
    item.editable = false;
    item.value = this.oldValue;
    if (item.string !== undefined) {
      item.string = this.dateService.formatTime(this.oldValue);
    }
    this.oldValue = null;
  }

  saveInput(item: any, note: NoteTime) {
    this.loading.show();
    this.noteTimeService.updateNoteTime(
      note,
      (date: any) => {
        this.loading.hide();
        item.editable = false;
        if (typeof this.oldValue === "number" && item.value === null) {
          item.value = 0;
        }
        this.oldValue = null;
        if (item.value instanceof Date) {
          item.value = this.dateService.formatStringToDateTime(item.string);
          this.calcInterval(note);
        }
        this.loadMyTasks();
      },
      ({error}: any) => {
        this.loading.hide();
        this.dialogService.open("Erro", error.message);
      }
    );
  }

  calcTotalIntervalBase(callbackReduce: any){
    let totalHours = new Date();
    totalHours.setHours(0, 0, 0, 0);
    totalHours = this.dataSource.reduce(callbackReduce, totalHours)
    return this.dateService.formatTime(totalHours);
  }

  callbackTotalInterval(sum: Date, item: NoteTime) {
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  callbackVstsTotal(sum: Date, item: NoteTime) {
    if(item.id_vsts.value == 0){
      return sum;
    }
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  callbackTaskTotal(sum: Date, item: NoteTime) {
    if(item.id_task.value == 0){
      return sum;
    }
    sum.setHours(
      sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
    );
    return sum;
  }

  calcTotalInterval() {
    return this.calcTotalIntervalBase(this.callbackTotalInterval);
  }

  calcTotalIntervalVsts() {
    return this.calcTotalIntervalBase(this.callbackVstsTotal);
  }

  calcTotalIntervalTask() {
    return this.calcTotalIntervalBase(this.callbackTaskTotal);
  }

  calcInterval(note: NoteTime) {
    note.interval = this.dateService.calcInterval(note.start_at.value, note.end_at.value);
  }

  calcIntervalModal(){
    this.modalData.interval = this.dateService.calcInterval(this.modalData.start_at.value, this.modalData.end_at.value);
    this.modalInterval = this.dateService.formatTime(this.modalData.interval);
  }
}
