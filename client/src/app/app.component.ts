import { Component } from '@angular/core';
import { MatDialog, MatSnackBar } from '@angular/material';
import { SigninComponent } from './dialogs/signin/signin.component';
import { SignupComponent } from './dialogs/signup/signup.component';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
    
    constructor(private matDialog: MatDialog,
                private matSnackBar: MatSnackBar) {
    }
    
    public showSignInDialog() {
        this.matDialog.open(SigninComponent);
    }

    public showSignUpDialog() {
        this.matDialog.open(SignupComponent);
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
