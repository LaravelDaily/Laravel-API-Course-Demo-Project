<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Knuckles\Scribe\Attributes\Group;

#[Group('Categories', 'Managing Categories')]
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"Categories"},
     *     summary="Get list of categories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *     )
     * )
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
