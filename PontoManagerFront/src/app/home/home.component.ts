import {Component, OnInit, ViewChild} from '@angular/core';
import { DateService } from '../services/date.service';
import {MatTable} from "@angular/material/table";
import {SelectionModel} from "@angular/cdk/collections";

export interface NoteTime {
  id: number,
  id_vsts: number,
  date: Date,
  start_at: Date,
  end_at: Date,
  end_at_string: string,
  interval: Date,
  id_task: number,
  isItInEdit: NoteTimeTableEdit
}

export interface NoteTimeTableEdit {
  id_vsts: boolean,
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

  @ViewChild(MatTable) table!: MatTable<NoteTime>;

  constructor(public dateService: DateService) { }

  ngOnInit(): void {
  }

  newTableEdit(): NoteTimeTableEdit{
    return {
      id_vsts: false,
      date: false,
      start_at: false,
      end_at: false,
      interval: false,
      id_task: false,
    };
  }

  newNoteTime(): NoteTime {
    return {
      end_at_string: "",
      id: this.dataSource.length+1,
      id_vsts: 1,
      id_task: 1,
      start_at: new Date(),
      date: new Date(),
      end_at: new Date(),
      interval: new Date,
      isItInEdit: this.newTableEdit()
    }
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

  showInputIdVsts(note: NoteTime){
    note.isItInEdit.id_vsts = true;
  }
  hideInputIdVsts(note: NoteTime){
    note.isItInEdit.id_vsts = false;
  }

  showInputIdTask(note: NoteTime){
    note.isItInEdit.id_task = true;
  }

  hideInputIdTask(note: NoteTime){
    note.isItInEdit.id_task = false;
  }

  showInputDate(note: NoteTime){
    note.isItInEdit.date = true;
  }

  hideInputDate(note: NoteTime){
    note.isItInEdit.date = false;
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

  hideInputEndAt(note: NoteTime){
    note.isItInEdit.end_at = false;
  }

  changeEndAt(note: NoteTime){
    if(note.end_at_string !== ''){
      note.end_at = this.dateService.formatStringToDateTime(note.end_at_string);
    }
  }
}
