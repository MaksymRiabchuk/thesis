<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $owners = User::all();

        if ($owners->isEmpty()) {
            $owners = User::factory()->count(5)->create();
        }

        $products = [
            'Electronics' => [
                ['title' => 'Sony A7III Camera', 'price' => 45, 'description' => 'Full-frame mirrorless camera, great for photo and video shoots. Comes with a 28-70mm kit lens.'],
                ['title' => 'DJI Mavic Pro Drone', 'price' => 35, 'description' => 'Compact 4K drone with obstacle avoidance, perfect for aerial photography.'],
                ['title' => 'Portable Projector', 'price' => 25, 'description' => 'HD portable projector with built-in speaker, ideal for movie nights and presentations.'],
                ['title' => 'MacBook Pro 16"', 'price' => 30, 'description' => 'Powerful laptop for video editing, design work, or development on the go.'],
            ],
            'Tools & Hardware' => [
                ['title' => 'Bosch Power Drill', 'price' => 10, 'description' => 'Cordless power drill with two batteries and a full bit set.'],
                ['title' => 'Angle Grinder', 'price' => 12, 'description' => 'Heavy-duty angle grinder for cutting and grinding metal or stone.'],
                ['title' => 'Pressure Washer', 'price' => 18, 'description' => 'Electric pressure washer, great for cleaning driveways, decks, and cars.'],
            ],
            'Sports & Outdoors' => [
                ['title' => 'Mountain Bike (Trek)', 'price' => 20, 'description' => 'Full-suspension mountain bike, serviced and ready for trails.'],
                ['title' => 'Camping Tent 4-person', 'price' => 15, 'description' => 'Waterproof 4-person tent, easy setup, includes footprint and stakes.'],
                ['title' => 'Kayak (Single)', 'price' => 22, 'description' => 'Sit-on-top kayak with paddle and life vest included.'],
                ['title' => 'Snowboard Set', 'price' => 28, 'description' => 'All-mountain snowboard with bindings and boots, sizes available on request.'],
            ],
            'Vehicles' => [
                ['title' => 'Electric Scooter', 'price' => 15, 'description' => 'Foldable electric scooter with 25km range, perfect for city commuting.'],
                ['title' => 'Cargo Trailer', 'price' => 25, 'description' => 'Small enclosed trailer, great for moving furniture or hauling equipment.'],
            ],
            'Photo & Video' => [
                ['title' => 'Studio Lighting Kit', 'price' => 20, 'description' => 'Two softbox lights with stands, ideal for portrait or product photography.'],
                ['title' => 'DJI Ronin Gimbal', 'price' => 27, 'description' => '3-axis gimbal stabilizer for smooth handheld video footage.'],
            ],
            'Home & Garden' => [
                ['title' => 'Lawn Mower', 'price' => 14, 'description' => 'Self-propelled gas lawn mower, recently serviced.'],
                ['title' => 'Hedge Trimmer', 'price' => 9, 'description' => 'Electric hedge trimmer, lightweight and easy to handle.'],
            ],
            'Party & Events' => [
                ['title' => 'PA Speaker System', 'price' => 32, 'description' => 'Portable PA system with two speakers and a mixer, great for small events.'],
                ['title' => 'Folding Table Set', 'price' => 12, 'description' => 'Set of 4 folding tables with matching chairs, seats up to 16 people.'],
            ],
        ];

        foreach ($products as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            foreach ($items as $item) {
                $isPublished = fake()->boolean(80);

                /** @var Offer $offer */
                $offer = Offer::create([
                    'user_id' => $owners->random()->id,
                    'category_id' => $category->id,
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']).'-'.Str::random(5),
                    'description' => $item['description'],
                    'price_per_day' => $item['price'],
                    'quantity' => fake()->numberBetween(1, 4),
                    'is_active' => fake()->boolean(90),
                    'is_published' => $isPublished,
                    'published_at' => $isPublished ? now()->subDays(fake()->numberBetween(0, 30)) : null,
                ]);

                $imageCount = fake()->numberBetween(2, 4);
                for ($i = 0; $i < $imageCount; $i++) {
                    $offer->images()->create([
                        'path' => "https://picsum.photos/seed/offer-{$offer->id}-{$i}/800/600",
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}