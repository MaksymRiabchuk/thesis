<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offers\StoreOfferRequest;
use App\Http\Requests\Admin\Offers\UpdateOfferRequest;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class OffersController extends Controller
{
    private const PER_PAGE_OPTIONS = [10, 25, 50, 100];

    private const SORTABLE_COLUMNS = [
        'title' => 'offers.title',
        'user' => 'users.name',
        'category' => 'categories.name',
        'price_per_day' => 'offers.price_per_day',
    ];

    public function index(Request $request): Response
    {
        [$offers, $sort, $direction] = $this->paginateOffers($request);

        return Inertia::render('Admin/Offers/Index', [
            'offers' => $offers,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function personalOffers(Request $request): Response
    {
        [$offers, $sort, $direction] = $this->paginateOffers($request, $request->user()->id);

        return Inertia::render('Admin/Offers/Index', [
            'offers' => $offers,
            'sort' => $sort,
            'direction' => $direction,
            'mineOnly' => true,
        ]);
    }

    private function paginateOffers(Request $request, ?int $userId = null): array
    {
        $perPage = $request->integer('per_page', 10);
        $perPage = in_array($perPage, self::PER_PAGE_OPTIONS, true) ? $perPage : 10;

        $sort = $request->string('sort')->toString();
        $direction = $request->string('direction')->toString() === 'desc' ? 'desc' : 'asc';
        $sortColumn = self::SORTABLE_COLUMNS[$sort] ?? null;

        $offers = Offer::query()
            ->select('offers.*')
            ->leftJoin('users', 'users.id', '=', 'offers.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'offers.category_id')
            ->with(['user:id,name', 'category:id,name'])
            ->when($userId, fn ($query) => $query->where('offers.user_id', $userId))
            ->when(
                $sortColumn,
                fn ($query) => $query->orderBy($sortColumn, $direction),
                fn ($query) => $query->latest('offers.created_at')
            )
            ->paginate($perPage)
            ->withQueryString();

        return [$offers, $sortColumn ? $sort : null, $sortColumn ? $direction : null];
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Offers/Edit', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'offer' => null,
        ]);
    }

    public function edit(Offer $offer): Response
    {
        $offer->load(['images:id,offer_id,path,sort_order']);

        return Inertia::render('Admin/Offers/Edit', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'offer' => $offer,
        ]);
    }

    public function store(StoreOfferRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $offer = Offer::create([
            'user_id' => $request->user()->id,
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $this->uniqueSlug($data['title']),
            'description' => $data['description'] ?? null,
            'price_per_day' => $data['price_per_day'],
            'quantity' => $data['quantity'],
            'is_active' => $request->boolean('is_active'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        $this->storeImages($offer, $request->file('images', []));

        return $this->successMessage('Offer created successfully.', 'admin.offers');
    }

    public function update(UpdateOfferRequest $request, Offer $offer): RedirectResponse
    {
        $data = $request->validated();

        $wasPublished = $offer->is_published;
        $isPublished = $request->boolean('is_published');

        $offer->update([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $data['title'] === $offer->title ? $offer->slug : $this->uniqueSlug($data['title'], $offer->id),
            'description' => $data['description'] ?? null,
            'price_per_day' => $data['price_per_day'],
            'quantity' => $data['quantity'],
            'is_active' => $request->boolean('is_active'),
            'is_published' => $isPublished,
            'published_at' => $isPublished && ! $wasPublished ? now() : $offer->published_at,
        ]);

        if (! empty($data['removed_image_ids'])) {
            $offer->images()
                ->whereIn('id', $data['removed_image_ids'])
                ->get()
                ->each(function ($image) {
                    if (Storage::disk('public')->exists($this->pathFromUrl($image->path))) {
                        Storage::disk('public')->delete($this->pathFromUrl($image->path));
                    }
                    $image->delete();
                });
        }

        $this->storeImages($offer, $request->file('images', []));

        return $this->successMessage('Offer updated successfully.', 'admin.offers');
    }

    private function storeImages(Offer $offer, array $files): void
    {
        if (empty($files)) {
            return;
        }

        $nextOrder = (int) $offer->images()->max('sort_order') + 1;

        foreach ($files as $file) {
            $path = $file->store('offers', 'public');

            $offer->images()->create([
                'path' => Storage::disk('public')->url($path),
                'sort_order' => $nextOrder++,
            ]);
        }
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            Offer::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function pathFromUrl(string $url): string
    {
        $publicUrl = Storage::disk('public')->url('');

        return Str::startsWith($url, $publicUrl) ? Str::after($url, $publicUrl) : $url;
    }
}