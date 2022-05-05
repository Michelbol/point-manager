import {Injectable} from '@angular/core';
import {HttpClient, HttpParams} from "@angular/common/http";
import {NoteTimeRequestMapper} from "../home/models/NoteTimeRequestMapper";

@Injectable({
  providedIn: 'root'
})
export class ApiAuthService {

  private urlBase = 'https://point-manager-api.herokuapp.com/'

  constructor(private http: HttpClient) {

  }

  myTasks(date: null | string) {
    if (date !== null) {
      return this.http.get(
        `${this.urlBase}/note-time`,
        {
          params: new HttpParams().set('date', date)
        });
    }
    return this.http.get(`${this.urlBase}/note-time`);
  }

  listTaskByDate(startAt: string, endAt: string) {
    return this.http.get(
      `${this.urlBase}/note-time`,
      {
        params: new HttpParams().set('start_at', startAt).set('end_at', endAt),
      });
  }

  generateExcel(startAt: string, endAt: string) {
    return this.http.post(
      `${this.urlBase}/note-time/export`,
      {
        start_at: startAt,
        end_at: endAt
      },
      {
        responseType: "blob"
      }
    );
  }

  createTask(note: NoteTimeRequestMapper) {
    return this.http.post(
      `${this.urlBase}/note-time`,
      note
    );
  }

  updateTask(note: NoteTimeRequestMapper) {
    return this.http.put(
      `${this.urlBase}/note-time/${note.id}`,
      note
    );
  }

  deleteManyTasks(notes: number[]) {
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
