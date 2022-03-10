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

  myTasks(success: Function, error: Function){
    return this.apiAuth.myTasks().subscribe({
      next: (data) => success(data),
      error: (res) => error(res)
    });
  }

  saveNoteTime(note: NoteTime, success: Function, error: Function) {
    const date = this.date.formatDateToServer(note.date.value);
    let mapperNote: NoteTimeRequestMapper = {
      id: null,
      end_at: `${date} ${note.end_at.string}`,
      start_at: `${date} ${note.start_at.string}`,
      id_vsts: note.id_vsts.value > 0 ? note.id_vsts.value : null,
      id_task: note.id_task.value > 0 ? note.id_task.value : null
    };
    return this
      .apiAuth
      .createTask(mapperNote)
      .subscribe({
        next: (data) => success(data, note),
        error: (res) => error(res)
      });
  }
}
