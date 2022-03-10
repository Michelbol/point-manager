import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {NoteTimeRequestMapper} from "../home/models/NoteTimeRequestMapper";
import {NoteTime} from "../home/models/NoteTime";

@Injectable({
  providedIn: 'root'
})
export class ApiAuthService {

  private urlBase = 'http://localhost'

  constructor(private http: HttpClient) {

  }

  myTasks(){
    return this.http.get(
      `${this.urlBase}/note-time/today`
    );
  }

  createTask(note: NoteTimeRequestMapper){
    return this.http.post(
      `${this.urlBase}/note-time`,
      {
        start_at: note.start_at,
        end_at: note.end_at,
        id_vsts: note.id_vsts,
        id_task: note.id_task
      }
    );
  }

  updateTask(note: NoteTimeRequestMapper){
    return this.http.put(
      `${this.urlBase}/note-time/${note.id}`,
      {
        start_at: note.start_at,
        end_at: note.end_at,
        id_vsts: note.id_vsts,
        id_task: note.id_task
      }
    );
  }

  deleteManyTasks(notes: number[]){
    return this.http.delete(
      `${this.urlBase}/note-time/many`,
      {
        body: {
          ids: notes
        }
      }
    );
  }
}
