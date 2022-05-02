import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private urlBase = 'http://localhost:81'

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
