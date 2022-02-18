import {Component, OnInit, ViewChild} from '@angular/core';
import { DateService } from '../services/date.service';
import {MatTable} from "@angular/material/table";
import {SelectionModel} from "@angular/cdk/collections";

export interface NoteTime {
  id: number,
  id_vsts: {
    value: number,
    editable: boolean
  },
  id_task: {
    value: number,
    editable: boolean
  },
  date: {
    value: Date,
    editable: boolean
  },
  start_at: {
    value: Date,
    editable: boolean,
    string: string
  },
  end_at: {
    value: Date,
    editable: boolean,
    string: string
  },
  interval: Date,
  isItInEdit: NoteTimeTableEdit
}

export interface EditableField {
  value: any,
  editable: boolean
}

export interface NoteTimeTableEdit {
  id_vsts: {
    editable: boolean
  },
  date: boolean,
  start_at: boolean,
  end_at: boolean,
  interval: boolean,
  id_task: boolean,
}

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.sass']
})
export class HomeComponent implements OnInit {
  dataSource: NoteTime[] = [];
  displayedColumns: string[] = ['select', 'id_vsts', 'id_task', 'date', 'start_at', 'end_at', 'interval'];
  selection = new SelectionModel<NoteTime>(true, []);
  oldValue: any;

  @ViewChild(MatTable) table!: MatTable<NoteTime>;

  constructor(public dateService: DateService) { }

  ngOnInit(): void {
  }

  newTableEdit(): NoteTimeTableEdit{
    return {
      id_vsts: {
        editable: false
      },
      date: false,
      start_at: false,
      end_at: false,
      interval: false,
      id_task: false,
    };
  }

  newNoteTime(): NoteTime {
    let note: NoteTime =  {
      id: this.dataSource.length+1,
      id_vsts: {
        value: 1,
        editable: false
      },
      id_task: {
        value: 1,
        editable: false
      },
      date: {
        value: new Date(),
        editable: false
      },
      start_at: {
        value: new Date(),
        editable: false,
        string: this.dateService.formatTime(new Date())
      },
      end_at: {
        value: new Date(),
        editable: false,
        string: this.dateService.formatTime(new Date())
      },
      interval: new Date,
      isItInEdit: this.newTableEdit()
    };
    note = this.calcInterval(note);
    return note;
  }

  addRow(note: NoteTime){
    this.dataSource.push(note);
    this.table.renderRows();
  }

  newRow(){
    this.addRow(this.newNoteTime());
    this.table.renderRows();
  }

  removeSelectRows(){
    for (let index in this.selection.selected) {
      this.removeDataSourceById(this.selection.selected[index].id)
    }
    this.selection.clear();
    this.table.renderRows();
  }

  removeDataSourceById(id: number){
    for (const noteTime in this.dataSource) {
      if(this.dataSource[noteTime].id === id){
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

  closeOthersInputs(){
    this.dataSource.map((item) => {
      if(item.id_vsts.editable){
        this.cancelInput(item.id_vsts);
      }
      if(item.id_task.editable){
        this.cancelInput(item.id_task);
      }
      if(item.date.editable){
        this.cancelInput(item.date);
      }
      if(item.start_at.editable){
        this.cancelInput(item.start_at);
      }
    })
  }

  showInput(item: any){
    this.closeOthersInputs();
    this.oldValue = item.value;
    item.editable = true;
  }

  cancelInput(item: any){
    item.editable = false;
    item.value = this.oldValue;
    if(item.string !== undefined){
      item.string = this.dateService.formatTime(this.oldValue);
    }
    this.oldValue = null;
  }

  saveInput(item: any, note: NoteTime){
    item.editable = false;
    this.oldValue = null;
    if(item.value instanceof Date){
        item.value = this.dateService.formatStringToDateTime(item.string);
      this.calcInterval(note);
    }
  }

  showInputStartAt(note: NoteTime){
    note.isItInEdit.start_at = true;
  }

  hideInputStartAt(note: NoteTime){
    note.isItInEdit.start_at = false;
  }

  showInputEndAt(note: NoteTime){
    note.isItInEdit.end_at = true;
  }

  changeEndAt(note: NoteTime){
    if(note.end_at.string !== ''){
      note.end_at.value = this.dateService.formatStringToDateTime(note.end_at.string);
    }
  }

  changeStartAt(note: NoteTime){
    console.log('alo?222');
    if(note.start_at.string !== ''){
      console.log('alo?');
      note.start_at.value = this.dateService.formatStringToDateTime(note.start_at.string);
    }
  }

  calcTotalInterval(){
    let totalHours = new Date();
    totalHours.setHours(0,0,0,0);
    totalHours = this.dataSource.reduce((sum, item) => {
      sum.setHours(
        sum.getHours() + item.interval.getHours(),
      sum.getMinutes() + item.interval.getMinutes()
      );
      return sum;
    }, totalHours)
    return this.dateService.formatTime(totalHours);
  }

  calcInterval(note: NoteTime){
    let hours = note.end_at.value.getHours() - note.start_at.value.getHours();
    let minutes = note.end_at.value.getMinutes() - note.start_at.value.getMinutes();
    let result = new Date();
    result.setHours(hours,minutes);
    note.interval = result;
    return note;
  }
}
