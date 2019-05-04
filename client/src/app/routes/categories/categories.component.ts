import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSidenav } from '@angular/material';
import { ProductsService } from '../../services/products.service';
import { CategoriesService } from '../../services/categories.service';
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
    public categories: Object[];

    public displayedColumns = ['productImage', 'name', 'price', 'actions'];

    @ViewChild('sidenav') sidenav: MatSidenav;

    constructor(private productsService: ProductsService,
                private categoriesService: CategoriesService,
                private route: ActivatedRoute,
                private router: Router) { 
    }

    public ngOnInit() {
        this.fetchProducts();
        this.fetchCategories();


        this.route.params.subscribe((params) => {
            this.activeCategory = params['id'];
        });
    }

    private fetchProducts() {
        this.productsService.getProducts().subscribe(response => {
            this.products = response['data']['categories'];

            setTimeout(() => {
                this.sidenav.toggle();
            }, 100);
        });
    }

    private fetchCategories() {
        this.categoriesService.getCategories().subscribe(response => {
            this.categories = response['data']['categories'];
        });
    }
}
