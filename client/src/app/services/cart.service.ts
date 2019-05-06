import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { AppSettings } from '../settings/app-settings';

@Injectable({
  providedIn: 'root'
})
export class CartService {

    constructor(private httpClient: HttpClient) { }

    public addToCart(cartItem: Object) {
        let body = JSON.stringify(cartItem);

        let httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt')
            })
        };

        return this.httpClient.post(AppSettings.API_ENDPOINT + 'cart', body, httpOptions);
    }

    public getCart() {
        let httpOptions = {
            headers: new HttpHeaders({
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('jwt')
            })
        };

        return this.httpClient.get(AppSettings.API_ENDPOINT + 'cart', httpOptions);
    }
}
