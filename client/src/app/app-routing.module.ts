import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './routes/home/home.component';
import { CategoriesComponent } from './routes/categories/categories.component';
import { OrdersComponent } from './routes/orders/orders.component';

const routes: Routes = [
    { path: '', component: HomeComponent },
    { path: 'categories/:id', component: CategoriesComponent },
    { path: 'orders', component: OrdersComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
