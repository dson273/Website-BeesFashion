<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view)
    {
        $categoryLimit = Category::whereNull('parent_category_id')
            ->where('fixed', 1)
            ->get();
        $view->with('categoryLimit', $categoryLimit);
    }
}
