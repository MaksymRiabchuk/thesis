<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CategoriesController extends Controller
{
    public function index(): Response
    {
        $categories = Category::query()
            ->withCount('offers')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => null,
        ]);
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Category::create([
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['name']),
        ]);

        return $this->successMessage('Category created successfully.', 'admin.categories');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $category->update([
            'name' => $data['name'],
            'slug' => $data['name'] === $category->name ? $category->slug : $this->uniqueSlug($data['name'], $category->id),
        ]);

        return $this->successMessage('Category updated successfully.', 'admin.categories');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->offers()->exists()) {
            return $this->errorMessage('Cannot delete a category that has offers assigned to it.', [], 'admin.categories');
        }

        $category->delete();

        return $this->successMessage('Category deleted successfully.', 'admin.categories');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
