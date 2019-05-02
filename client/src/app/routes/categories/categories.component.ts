import { Component, OnInit } from '@angular/core';
import { MatSidenav } from '@angular/material';
import { ProductsService } from '../../services/products.service';
import { switchMap } from 'rxjs/operators';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.css']
})
export class CategoriesComponent implements OnInit {

    public products: Object[];
    public activeCategory: number;

    constructor(private productsService: ProductsService,
                private route: ActivatedRoute,
                private router: Router) { 
    }

    ngOnInit() {
        this.fetchProducts();

        this.route.params.subscribe((params) => {
            this.activeCategory = params['id'];
        });
    }

    private fetchProducts() {
        this.productsService.getProducts().subscribe(response => {
            this.products = response['data']['categories'];
        });
    }
}
