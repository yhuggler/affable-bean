import { Component, OnInit } from '@angular/core';
import { OrdersService } from '../../services/orders.service';

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.css']
})
export class OrdersComponent implements OnInit {

    public orders: Object[];
    public displayedColumns = ['id', 'userId', 'amount', 'confirmationNumber', 'promoCode', 'dateCreated'];
    
    constructor(private ordersService: OrdersService) { }

    ngOnInit() {
        this.fetchOrders();
    }

    private fetchOrders() {
        this.ordersService.getOrders().subscribe(response => {
            this.orders = response['data']['orders'];
        }); 
    }

}
