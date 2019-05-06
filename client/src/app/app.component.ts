import { Component } from '@angular/core';
import { MatDialog, MatSnackBar } from '@angular/material';
import { SigninComponent } from './dialogs/signin/signin.component';
import { SignupComponent } from './dialogs/signup/signup.component';
import { ShoppingCartComponent } from './dialogs/shopping-cart/shopping-cart.component';
import { CartService } from './services/cart.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

    public shoppingCartItems: Object[];

    constructor(private matDialog: MatDialog,
                private matSnackBar: MatSnackBar,
                private cartService: CartService) {

        this.getShoppingCartItems();

    }

    public getShoppingCartItems() {
        if (this.isLoggedIn()) {
            this.cartService.getCart().subscribe(response => {
                this.shoppingCartItems = response['data']['shoppingCart']['shoppingCartItems'];
            });
        }
    }

    public showSignInDialog() {
        this.matDialog.open(SigninComponent);
    }

    public showSignUpDialog() {
        this.matDialog.open(SignupComponent);
    }

    public showShoppingCart() {
        this.matDialog.open(ShoppingCartComponent);
    }

    public handleLogout() {
        localStorage.removeItem('jwt');
    
        this.matSnackBar.open('You successfully logged out.', 'Dismiss', {
          duration: 2000,
        });
    }

    public isLoggedIn() {
        return localStorage.getItem('jwt') !== null;
    }
}
