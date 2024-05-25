<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryTreeResource;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', false);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Category::query();
        $query->orderBy($sortField, $sortDirection);
        if ($search){
            $query->where('name', 'like', "%{$search}%")
            ->orWHere('email', 'like', "%{$search}%");
        }
        return CategoryResource::collection($query->paginate($perPage));
    }

    public function show()
    {
        return Category::getActiveAsTree(CategoryTreeResource::class);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $category->update($data);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();

    }
}
