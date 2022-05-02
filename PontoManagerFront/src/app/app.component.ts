import { Component } from '@angular/core';
import {LoadingService} from "./services/loading.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})
export class AppComponent {
  title = 'PontoManagerFront';

  constructor(public loading: LoadingService) {
  }

}
