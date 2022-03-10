import { Injectable } from '@angular/core';
import {
  HttpEvent, HttpInterceptor, HttpHandler, HttpRequest
} from '@angular/common/http';
import {AuthService} from "../services/auth.service";
import {Router} from "@angular/router";

@Injectable()
export class AuthInterceptor implements HttpInterceptor {

  constructor(private authService: AuthService, private router: Router) {}

  intercept(req: HttpRequest<any>, next: HttpHandler) {
    if(!this.authService.isAuth()){
      this.router.navigate(['/login']);
      return next.handle(req);
    }
    const authToken = this.authService.getToken();

    const authReq = req.clone({
      headers: req.headers.set('Authorization', `${authToken}`)
    });

    return next.handle(authReq);
  }
}
