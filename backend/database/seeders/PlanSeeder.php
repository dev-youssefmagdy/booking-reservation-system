<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'price' => 29.00,
                'billing_cycle' => 'monthly',
                'max_bookings' => 100,
                'max_resources' => 5,
                'max_staff' => 3,
                'features' => [
                    'has_api' => false,
                    'has_erp' => false,
                    'has_custom_domain' => false,
                    'has_whatsapp' => false,
                    'has_channel_manager' => false,
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Growth',
                'slug' => 'growth',
                'price' => 79.00,
                'billing_cycle' => 'monthly',
                'max_bookings' => 500,
                'max_resources' => 20,
                'max_staff' => 10,
                'features' => [
                    'has_api' => true,
                    'has_erp' => false,
                    'has_custom_domain' => true,
                    'has_whatsapp' => true,
                    'has_channel_manager' => false,
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 199.00,
                'billing_cycle' => 'monthly',
                'max_bookings' => 0,
                'max_resources' => 0,
                'max_staff' => 0,
                'features' => [
                    'has_api' => true,
                    'has_erp' => true,
                    'has_custom_domain' => true,
                    'has_whatsapp' => true,
                    'has_channel_manager' => true,
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
