<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans — Central Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Subscription Plans</h1>
        <div class="flex gap-3">
            <a href="{{ route('central.plans.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                + New Plan
            </a>
            <a href="{{ route('central.plans.index') }}?features=1"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium">
                Feature Matrix
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Plan cards grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
        <div class="bg-white rounded-xl shadow p-6 flex flex-col">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $plan->name }}</h2>
                    <span class="text-xs text-gray-400 font-mono">{{ $plan->slug }}</span>
                </div>
                <span class="text-sm px-2 py-1 rounded-full font-medium
                    {{ $plan->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="mb-4">
                <span class="text-3xl font-bold text-gray-900">${{ number_format($plan->price, 2) }}</span>
                <span class="text-gray-500 text-sm"> / {{ $plan->billing_cycle }}</span>
            </div>

            <ul class="space-y-2 text-sm text-gray-600 mb-6 flex-1">
                <li class="flex justify-between">
                    <span>Bookings</span>
                    <span class="font-medium">{{ $plan->max_bookings === 0 || $plan->max_bookings === null ? 'Unlimited' : $plan->max_bookings }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Resources</span>
                    <span class="font-medium">{{ $plan->max_resources === null ? 'Unlimited' : $plan->max_resources }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Staff</span>
                    <span class="font-medium">{{ $plan->max_staff === null ? 'Unlimited' : $plan->max_staff }}</span>
                </li>
            </ul>

            @if($plan->features)
            <div class="flex flex-wrap gap-1 mb-4">
                @foreach($plan->features as $key => $val)
                    @if($val)
                    <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded">
                        {{ \App\Enums\PlanFeature::from($key)?->label() ?? $key }}
                    </span>
                    @endif
                @endforeach
            </div>
            @endif

            <div class="text-xs text-gray-400 mb-4">
                {{ $plan->subscriptions_count }} tenant(s) subscribed
            </div>

            <div class="flex gap-2 mt-auto">
                <a href="{{ route('central.plans.edit', $plan) }}"
                   class="flex-1 text-center py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 font-medium text-sm">
                    Edit
                </a>
                <form method="POST" action="{{ route('central.plans.destroy', $plan) }}"
                      onsubmit="return confirm('Delete {{ $plan->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="py-2 px-4 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-medium text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <p class="text-lg">No plans yet.</p>
            <a href="{{ route('central.plans.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                Create your first plan
            </a>
        </div>
        @endforelse
    </div>
</div>
</body>
</html>
