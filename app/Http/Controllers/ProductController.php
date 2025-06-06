<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index()
    {

        $query = Product::query();
        
        return $this->renderProducts($query);

    }

    public function about_us()
    {
        return view('info.about_us');
    }

    public function contact_us()
    {
        return view('info.contact_us');
    }

    public function shipping_policy()
    {
        return view('info.shipping_policy');
    }

    public function view(Product $product)
    {
        return view('product.view', ['product' => $product]);
    }

    public function byCategory(Category $category)
    {
        $categories = Category::getAllChildrenByParent($category);

        $query = Product::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')

            ->whereIn('pc.category_id', array_map(fn ($c) => $c->id, $categories));

        return $this->renderProducts($query);
    }

    private function renderProducts(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $products = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                /** @var $query \Illuminate\Database\Eloquent\Builder */
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })

            ->paginate(10);

        return view('product.index', [
            'products' => $products
        ]);

    }
}

