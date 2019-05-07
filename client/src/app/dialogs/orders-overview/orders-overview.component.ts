import { Component, OnInit, Inject } from '@angular/core';
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';

@Component({
  selector: 'app-orders-overview',
  templateUrl: './orders-overview.component.html',
  styleUrls: ['./orders-overview.component.css']
})
export class OrdersOverviewComponent implements OnInit {

    public order: Object;
    public displayedColumns = ['productImage', 'name', 'price', 'quantity'];

    constructor(@Inject(MAT_DIALOG_DATA) public data: any) {
        this.order = data['order'];
    }

    ngOnInit() {
    }
    
    public getPriceMultipliedByQuantity(unitPrice: number, quantity: number) {
        const price = unitPrice * quantity;
        return Math.round(price * 100) / 100
    }

}
