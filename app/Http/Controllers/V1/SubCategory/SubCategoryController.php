<?php

namespace App\Http\Controllers\V1\SubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\V1\SubCategory\SubCategory;
use App\Http\Resources\V1\SubCategory\SubCategoryResource;
use App\Http\Requests\V1\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\V1\SubCategory\UpdateSubCategoryRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return self::paginated(SubCategory::with('category')->paginate(10), SubCategoryResource::class, 'SubCategories retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategory::create($request->validated());
        return self::success(new SubCategoryResource($subCategory), 'SubCategory created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        $subCategory->load('category');
        return self::success(new SubCategoryResource($subCategory), 'SubCategory retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        $subCategory->update($request->validated());
        return self::success(new SubCategoryResource($subCategory), 'SubCategory updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
         $subCategory->delete();
        return self::success(null, 'SubCategory deleted successfully', 204);
    }
    
}
