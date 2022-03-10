import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {NoteTime} from "../home/models/NoteTime";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private urlBase = 'http://localhost'

  constructor(private http: HttpClient) { }

  token(username:string, password: string) {
    return this.http.post(
      `${this.urlBase}/task/token`,
      {
        username,
        password
      }
    );
  }


}
