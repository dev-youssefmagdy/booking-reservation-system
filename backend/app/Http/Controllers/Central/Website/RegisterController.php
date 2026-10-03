<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central\Website;

use App\Enums\BookingType;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\Central\TenantManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(private readonly TenantManagementService $tenantService) {}

    public function index(): View
    {
        $bookingTypes = BookingType::cases();

        return view('central.website.register', compact('bookingTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'business_type' => ['required', 'string', 'in:'.implode(',', array_column(BookingType::cases(), 'value'))],
            'subdomain' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-]+$/', 'max:63'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $centralDomain = config('tenancy.central_domains.0', 'localhost');
        $domain = $validated['subdomain'].'.'.$centralDomain;

        $plan = Plan::first();

        $this->tenantService->create([
            'name' => $validated['name'],
            'contact_name' => $validated['name'],
            'contact_email' => $validated['email'],
            'business_type' => $validated['business_type'],
            'domain' => $domain,
            'plan_id' => $plan?->id,
        ]);

        return redirect()->route('central.website.home')
            ->with('success', 'Your business has been registered! We\'re setting up your account.');
    }
}
