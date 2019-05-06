import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { UserService } from '../../services/user.service';
import { MatSnackBar, MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {

    loginForm: FormGroup;

    constructor(private formBuilder: FormBuilder, 
                private userService: UserService, 
                private snackBar: MatSnackBar,
                private dialogRef: MatDialogRef<SigninComponent>) {}

    ngOnInit() {
        this.createFormGroup();
    }

    private createFormGroup() {
        this.loginForm = new FormGroup({
            email: new FormControl('', [Validators.required]),
            password: new FormControl('', Validators.required),
        });
    }

    public handleSignin() {
        const user = {
            email: this.loginForm.value['email'],
            password: this.loginForm.value['password']
        }

        this.userService.signin(user).subscribe(data => {
            if (!data['error']) {
                this.dialogRef.close();
                localStorage.setItem('jwt', data['jwt']);
            }

            this.snackBar.open(data['message'], 'Dismiss', {
              duration: 2000,
            });
        });
    }
}
