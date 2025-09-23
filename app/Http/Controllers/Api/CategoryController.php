<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;

#[Group('Categories', 'Managing Categories')]
class CategoryController extends Controller
{
    /**
     * Get Categories
     *
     * Getting the list of the categories
     * 
     * @queryParam page Which page to show. Example: 12
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * POST categories
     *
     * @bodyParam name string required Name of the category. Example: "Clothing"
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['photo'] = $request->file('photo')->store('categories', 'public');

        $category = Category::create($data);
        
        return new CategoryResource($category);
    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->validated());
        
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        
        return response()->noContent();
    }
}
