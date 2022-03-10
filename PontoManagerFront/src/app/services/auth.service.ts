import {Injectable} from '@angular/core';
import {ApiService} from "./api.service";
import {LocalStorageService} from "./local-storage.service";
import {StorageEnum} from "../enums/storage.enum";
import {Router} from "@angular/router";
import {DialogService} from "./dialog.service";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(
    private api: ApiService,
    private storage: LocalStorageService,
    private router: Router,
    private dialogService: DialogService
  ) {  }

  auth(username: string, password: string) {
    this.api.token(username, password).subscribe({
      next: (data) => this.successAuth(data),
      error: (error) => this.errorAuth(error)
    });
  }

  getToken(){
    return this.storage.get(StorageEnum.basic_token);
  }

  isAuth(){
    let expireAt = new Date(Date.parse(this.storage.get(StorageEnum.expireAt)));
    return expireAt.getTime() > (new Date()).getTime();
  }

  private static generateBasicAuth(userId: number, username: string): string {
    return btoa(`${username}:${userId}`);
  }

  private successAuth({data}: any) {
    this.storage.set(StorageEnum.basic_token, AuthService.generateBasicAuth(data.user_data.id, data.user_data.username));
    this.storage.set(StorageEnum.expireAt, data.user_data.expire_at);
    this.router.navigate(['/home']);
  }

  private errorAuth({error}: any) {
    this.dialogService.open('Erro', error.message);
  }
}
