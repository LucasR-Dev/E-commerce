<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCategoryFormRequest $request)
    {
        $category = $request->validated();
        $newCategory = Category::create($category);

        return response()->json([
            'message' => 'Category created successfully!',
            'data' => $newCategory
        ]); 

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
