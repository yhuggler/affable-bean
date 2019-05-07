import { Component, OnInit } from '@angular/core';
import { OrdersService } from '../../services/orders.service';
import { MatDialog } from '@angular/material';
import { OrdersOverviewComponent } from '../../dialogs/orders-overview/orders-overview.component';

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.css']
})
export class OrdersComponent implements OnInit {

    public orders: Object[];
    public displayedColumns = ['id', 'userId', 'amount', 'confirmationNumber', 'promoCode', 'dateCreated'];
    
    constructor(private ordersService: OrdersService,
                private matDialog: MatDialog) { }

    ngOnInit() {
        this.fetchOrders();
    }

    private fetchOrders() {
        this.ordersService.getOrders().subscribe(response => {
            this.orders = response['data']['orders'];
        }); 
    }

    public showDetailedOrder(order: Object) {
        this.matDialog.open(OrdersOverviewComponent, {
            data: {
                order: order
            }
        });
    }

}
