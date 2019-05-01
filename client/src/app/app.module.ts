import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MaterialImports } from './material-imports';
import { CategoryOverviewComponent } from './components/category-overview/category-overview.component';

@NgModule({
  declarations: [
    AppComponent,
    CategoryOverviewComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
      ReactiveFormsModule,
      HttpClientModule,
      MaterialImports
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
