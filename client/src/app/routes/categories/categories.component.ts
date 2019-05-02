import { Component, OnInit, ChangeDetectorRef, ViewChild } from '@angular/core';
import { MatSidenav } from '@angular/material';
import { ProductsService } from '../../services/products.service';
import {MediaMatcher} from '@angular/cdk/layout';
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
    public mobileQuery: MediaQueryList;
    private _mobileQueryListener: () => void;
    
    @ViewChild(MatSidenav) snav: MatSidenav;
    
    constructor(private productsService: ProductsService,
                private route: ActivatedRoute,
                private router: Router,
                private changeDetectorRef: ChangeDetectorRef, 
                private media: MediaMatcher) { 

        this.mobileQuery = media.matchMedia('(max-width: 600px)');
        this._mobileQueryListener = () => changeDetectorRef.detectChanges();
        this.mobileQuery.addListener(this._mobileQueryListener);
    }

    ngOnInit() {
        this.snav.open();
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
