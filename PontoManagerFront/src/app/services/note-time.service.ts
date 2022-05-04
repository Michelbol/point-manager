import {Injectable} from '@angular/core';
import {NoteTime} from "../home/models/NoteTime";
import {ApiAuthService} from "./api-auth.service";
import {DateService} from "./date.service";
import {NoteTimeRequestMapper} from "../home/models/NoteTimeRequestMapper";

@Injectable({
  providedIn: 'root'
})
export class NoteTimeService {

  constructor(
    private apiAuth: ApiAuthService,
    private date: DateService,
  ) {
  }

  myTasks(date: Date, success: Function, error: Function) {
    return this.apiAuth
      .myTasks(this.date.formatDateToServer(date))
      .subscribe({
        next: (data) => success(data),
        error: (res) => error(res)
      });
  }

  generateExcel(startAt: Date, endAt: Date, success: Function, error: Function){
    return this.apiAuth
      .generateExcel(
        this.date.formatDateToServer(startAt),
        this.date.formatDateToServer(endAt),
      )
      .subscribe({
        next: (data) => success(data),
        error: (res) => error(res)
      });
  }

  listTaskByDate(startAt: Date, endAt: Date, success: Function, error: Function) {
    return this.apiAuth
      .listTaskByDate(
        this.date.formatDateToServer(startAt),
        this.date.formatDateToServer(endAt),
      )
      .subscribe({
        next: (data) => success(data),
        error: (res) => error(res)
      });
  }

  saveNoteTime(note: NoteTime, success: Function, error: Function) {
    const date = this.date.formatDateToServer(note.date.value);
    const mapperNote: NoteTimeRequestMapper = {
      id: null,
      end_at: `${date} ${note.end_at.string}`,
      start_at: `${date} ${note.start_at.string}`,
      id_vsts: Number(note.id_vsts.value),
      id_task: Number(note.id_task.value),
      description: note.description.value,
    };
    return this
      .apiAuth
      .createTask(mapperNote)
      .subscribe({
        next: (data) => success(data, note),
        error: (res) => error(res)
      });
  }

  updateNoteTime(note: NoteTime, success: Function, error: Function) {
    const date = this.date.formatDateToServer(note.date.value);
    const mapperNote: NoteTimeRequestMapper = {
      id: note.id,
      end_at: `${date} ${note.end_at.string}`,
      start_at: `${date} ${note.start_at.string}`,
      id_vsts: note.id_vsts.value,
      id_task: note.id_task.value,
      description: note.description.value,
    };
    return this
      .apiAuth
      .updateTask(mapperNote)
      .subscribe({
        next: (data) => success(data, note),
        error: (res) => error(res)
      });
  }

  deleteMany(note: NoteTime[], success: Function, error: Function) {
    let ids: number[] = note.map((item) => {
      return item.id
    });
    this
      .apiAuth
      .deleteManyTasks(ids)
      .subscribe({
        next: (data) => success(data, note),
        error: (res) => error(res)
      })
  }
}
