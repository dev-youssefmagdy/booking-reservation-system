<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $plan->name }} — Central Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('central.plans.index') }}" class="text-gray-500 hover:text-gray-700">← Plans</a>
        <h1 class="text-2xl font-bold text-gray-800">{{ $plan->name }}</h1>
        <span class="px-2 py-0.5 rounded-full text-xs font-medium
            {{ $plan->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
            {{ $plan->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Slug</dt>
                <dd class="font-mono font-medium text-gray-800">{{ $plan->slug }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Price</dt>
                <dd class="font-medium text-gray-800">${{ number_format($plan->price, 2) }} / {{ $plan->billing_cycle }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Max Bookings</dt>
                <dd class="font-medium text-gray-800">{{ $plan->max_bookings === 0 || $plan->max_bookings === null ? 'Unlimited' : $plan->max_bookings }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Max Resources</dt>
                <dd class="font-medium text-gray-800">{{ $plan->max_resources ?? 'Unlimited' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Max Staff</dt>
                <dd class="font-medium text-gray-800">{{ $plan->max_staff ?? 'Unlimited' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Subscribers</dt>
                <dd class="font-medium text-gray-800">{{ $plan->subscriptions_count }}</dd>
            </div>
        </dl>

        @if($plan->features)
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Features</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($plan->features as $key => $val)
                    @if($val)
                    <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded">
                        {{ \App\Enums\PlanFeature::from($key)?->label() ?? $key }}
                    </span>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex gap-3 pt-4">
            <a href="{{ route('central.plans.edit', $plan) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
                Edit
            </a>
            <a href="{{ route('central.plans.index') }}"
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm">
                Back
            </a>
        </div>
    </div>
</div>
</body>
</html>
