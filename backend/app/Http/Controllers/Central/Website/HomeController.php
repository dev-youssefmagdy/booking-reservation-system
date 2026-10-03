<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Website;

use App\Enums\BookingType;
use App\Enums\TenantStatus;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = BookingType::cases();

        $categoryCounts = Tenant::query()
            ->where('status', TenantStatus::Active)
            ->selectRaw('business_type, COUNT(*) as count')
            ->groupBy('business_type')
            ->pluck('count', 'business_type')
            ->toArray();

        $featuredTenants = Tenant::query()
            ->where('status', TenantStatus::Active)
            ->latest()
            ->limit(8)
            ->get();

        return view('central.website.home', compact('categories', 'categoryCounts', 'featuredTenants'));
    }
}
