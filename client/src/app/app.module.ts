import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MaterialImports } from './material-imports';
import { CategoryOverviewComponent } from './components/category-overview/category-overview.component';
import { CategoriesComponent } from './routes/categories/categories.component';
import { HomeComponent } from './routes/home/home.component';
import { SigninComponent } from './dialogs/signin/signin.component';
import { SignupComponent } from './dialogs/signup/signup.component';

@NgModule({
  declarations: [
    AppComponent,
    CategoryOverviewComponent,
    CategoriesComponent,
    HomeComponent,
    SigninComponent,
    SignupComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
      ReactiveFormsModule,
      HttpClientModule,
      MaterialImports
  ],
  entryComponents: [
    SigninComponent,
    SignupComponent
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
