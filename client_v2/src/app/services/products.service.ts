import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { AppSettings } from '../settings/app-settings';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {
    
    constructor(private httpClient: HttpClient) { }

    public getProducts() {
        let httpOptions = {
          headers: new HttpHeaders({
            'Content-Type': 'application/json',
          })
        };

        return this.httpClient.get(AppSettings.API_ENDPOINT + 'products', httpOptions);
    }
}
