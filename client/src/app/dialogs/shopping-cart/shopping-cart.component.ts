import { Component, OnInit } from '@angular/core';
import { CartService } from '../../services/cart.service';
import { CheckoutComponent } from '../checkout/checkout.component';
import { MatDialog } from '@angular/material';

@Component({
  selector: 'app-shopping-cart',
  templateUrl: './shopping-cart.component.html',
  styleUrls: ['./shopping-cart.component.css']
})
export class ShoppingCartComponent implements OnInit {

    public shoppingCart: Object[];
    public displayedColumns = ['productImage', 'name', 'price', 'actions'];

    constructor(private cartService: CartService,
                private matDialog: MatDialog) { }

    ngOnInit() {
        this.fetchShoppingCartItems();        
    }

    private fetchShoppingCartItems() {
        this.cartService.getCart().subscribe(response => {
            this.shoppingCart = response['data']['shoppingCart'];
        });
    }

    public updateQuantity(item: Object, quantityChange: number) {
        const newQuantity = Number(item['quantity']) + Number(quantityChange);
        
        this.cartService.updateQuantity(item['id'], newQuantity).subscribe(response => {
            this.fetchShoppingCartItems();
        });
    }

    public showCheckoutDialog() {
        this.matDialog.open(CheckoutComponent, {
            minWidth: '40%'
        });
    }

    public getPriceMultipliedByQuantity(unitPrice: number, quantity: number) {
        const price = unitPrice * quantity;
        return Math.round(price * 100) / 100
    }

}
