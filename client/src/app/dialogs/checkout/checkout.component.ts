import { Component, OnInit } from '@angular/core';
import { OrdersService } from '../../services/orders.service';
import { CartService } from '../../services/cart.service';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { MatSnackBar, MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.css']
})
export class CheckoutComponent implements OnInit {

    public subTotal: string;
    public deliveryFee: number = 3;
    public total: string;
    public promoCode: string = "";

    public promoCodeFormGroup: FormGroup;

    constructor(private ordersService: OrdersService,
                private cartService: CartService,
                private matSnackBar: MatSnackBar,
                public dialogRef: MatDialogRef<CheckoutComponent>) { }

    ngOnInit() {
        this.fetchTotal();
        this.createFormGroup();
    }

    private fetchTotal() {
        this.cartService.getCart().subscribe(response => {
            this.subTotal = response['data']['shoppingCart']['totalCost'];

            this.total = '$' + String(Number(this.subTotal.split('$')[1]) + this.deliveryFee);
        });
    }

    private createFormGroup() {
        this.promoCodeFormGroup = new FormGroup({
            promoCode: new FormControl('', [Validators.max(45)])
        });
    }

    public addOrder() {
        const order = {
            promoCode: this.promoCodeFormGroup.value['promoCode']
        };

        this.ordersService.addOrder(order).subscribe(response => {
            this.matSnackBar.open(response['message'], 'Dismiss', {
              duration: 2000,
            });

            this.dialogRef.close(true);
        });
    }
}
