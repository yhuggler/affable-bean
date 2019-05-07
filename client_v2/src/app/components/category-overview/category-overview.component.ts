import { Component, OnInit } from '@angular/core';
import { CategoriesService } from '../../services/categories.service';

@Component({
  selector: 'app-category-overview',
  templateUrl: './category-overview.component.html',
  styleUrls: ['./category-overview.component.css']
})
export class CategoryOverviewComponent implements OnInit {

    public categories: Object[];

    constructor(private categoriesService: CategoriesService) { }

    ngOnInit() {
        this.categoriesService.getCategories().subscribe(response => {
            this.categories = response['data']['categories'];
        });     
    }

}
