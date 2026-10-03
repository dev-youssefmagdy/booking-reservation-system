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
                    'HasApi' => false,
                    'HasErp' => false,
                    'HasCustomDomain' => false,
                    'HasWhatsApp' => false,
                    'HasChannelManager' => false,
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
                    'HasApi' => true,
                    'HasErp' => false,
                    'HasCustomDomain' => true,
                    'HasWhatsApp' => true,
                    'HasChannelManager' => false,
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
                    'HasApi' => true,
                    'HasErp' => true,
                    'HasCustomDomain' => true,
                    'HasWhatsApp' => true,
                    'HasChannelManager' => true,
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
