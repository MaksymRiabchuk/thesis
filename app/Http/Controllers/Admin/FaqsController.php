<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faqs\StoreFaqRequest;
use App\Http\Requests\Admin\Faqs\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FaqsController extends Controller
{
    private const PER_PAGE_OPTIONS = [10, 25, 50, 100];

    private const SORTABLE_COLUMNS = ['question', 'created_at'];

    public function index(Request $request): Response
    {
        $perPage = $request->integer('per_page', 10);
        $perPage = in_array($perPage, self::PER_PAGE_OPTIONS, true) ? $perPage : 10;

        $sort = $request->string('sort')->toString();
        $direction = $request->string('direction')->toString() === 'desc' ? 'desc' : 'asc';
        $sortColumn = in_array($sort, self::SORTABLE_COLUMNS, true) ? $sort : null;

        $faqs = Faq::query()
            ->when(
                $sortColumn,
                fn ($query) => $query->orderBy($sortColumn, $direction),
                fn ($query) => $query->latest()
            )
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/Faqs/Index', [
            'faqs' => $faqs,
            'sort' => $sortColumn,
            'direction' => $sortColumn ? $direction : null,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Faqs/Edit', [
            'faq' => null,
        ]);
    }

    public function edit(Faq $faq): Response
    {
        return Inertia::render('Admin/Faqs/Edit', [
            'faq' => $faq,
        ]);
    }

    public function store(StoreFaqRequest $request): RedirectResponse
    {
        Faq::create($request->validated());

        return $this->successMessage('FAQ created successfully.', 'admin.faqs');
    }

    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());

        return $this->successMessage('FAQ updated successfully.', 'admin.faqs');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return $this->successMessage('FAQ deleted successfully.', 'admin.faqs');
    }
}
