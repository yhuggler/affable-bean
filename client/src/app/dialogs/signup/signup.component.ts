import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { patternValidator } from '../../shared/pattern-validator';
import { UserService } from '../../services/user.service';
import { MatSnackBar, MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {

    signupForm: FormGroup;

    constructor(private formBuilder: FormBuilder, private userService: UserService, private snackBar: MatSnackBar,
                private dialogRef: MatDialogRef<SignupComponent>) { }

    ngOnInit() {
        this.createFormGroup();
    }

  createFormGroup() {
    this.signupForm = this.formBuilder.group({
        name: new FormControl('', Validators.required),
        email: new FormControl('', [Validators.required, Validators.email]),
        password: new FormControl('', Validators.required),
        repeatPassword: new FormControl('', Validators.required),
        phone: new FormControl('', Validators.required),
        street: new FormControl('', Validators.required),
        city: new FormControl('', Validators.required),
        creditCardNumber: new FormControl('', Validators.required)
    });
  }

    handleSignup() {
        const user = {
            name: this.signupForm.value['name'],
            email: this.signupForm.value['email'],
            password: this.signupForm.value['password'],
            repeatPassword: this.signupForm.value['repeatPassword'],
            phone: this.signupForm.value['phone'],
            street: this.signupForm.value['street'],
            city: this.signupForm.value['city'],
            creditCardNumber: this.signupForm.value['creditCardNumber']
        }
        
        this.userService.signup(user).subscribe(data => {
          if (data['message']) {
            this.snackBar.open(data['message'], 'Dismiss', {
              duration: 2000,
            });
            this.dialogRef.close();
          }
        });
    }
}
