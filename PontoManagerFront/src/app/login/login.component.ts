import { Component, OnInit } from '@angular/core';
import {AuthService} from "../services/auth.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass']
})
export class LoginComponent implements OnInit {

  username: string = '';

  password: string = '';


  constructor(private authService: AuthService) { }

  ngOnInit(): void {
  }

  sendLogin(){
    this.authService.auth(this.username, this.password);
  }

}
