import { Component } from '@angular/core';
import {LoadingService} from "./services/loading.service";
import {AuthService} from "./services/auth.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})
export class AppComponent {
  title = 'PontoManagerFront';

  constructor(
    public loading: LoadingService,
    public authService: AuthService
  ) {
  }

  isLogged(){
    return this.authService.isAuth();
  }
}
