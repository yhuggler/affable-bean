import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { AppSettings } from '../settings/app-settings';

@Injectable({
  providedIn: 'root'
})
export class CategoriesService {

    constructor(private httpClient: HttpClient) { }

    public getCategories() {
        let httpOptions = {
          headers: new HttpHeaders({
            'Content-Type': 'application/json',
          })
        };

        return this.httpClient.get(AppSettings.API_ENDPOINT + 'categories', httpOptions);
    }

}
