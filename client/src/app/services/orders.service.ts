import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { AppSettings } from '../settings/app-settings';

@Injectable({
  providedIn: 'root'
})
export class OrdersService {
    
    constructor(private httpClient: HttpClient) { }
    
    public getOrders() {
        let httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt')
            })
        };

        return this.httpClient.get(AppSettings.API_ENDPOINT + 'orders', httpOptions);
    }

    public addOrder(order: Object) {
        let body = JSON.stringify(order);

        let httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt')
            })
        };

        return this.httpClient.post(AppSettings.API_ENDPOINT + 'orders', body, httpOptions);
    }
}
