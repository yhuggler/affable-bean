import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { AppSettings } from '../settings/app-settings';

@Injectable({
  providedIn: 'root'
})
export class UserService {

    constructor(private httpClient: HttpClient) { }

    public signin(user: object) {
        let httpOptions = {
          headers: new HttpHeaders({
            'Content-Type': 'application/json',
          })
        };

        let body = JSON.stringify(user);

        return this.httpClient.post(AppSettings.API_ENDPOINT + 'user/signin', body, httpOptions);
    }

    public singup(user: object) {
        let httpOptions = {
          headers: new HttpHeaders({
            'Content-Type': 'application/json',
          })
        };

        let body = JSON.stringify(user);

        return this.httpClient.post(AppSettings.API_ENDPOINT + 'user/signup', body, httpOptions);
    }

}
