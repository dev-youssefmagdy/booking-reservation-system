<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Plan — Central Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('central.plans.index') }}" class="text-gray-500 hover:text-gray-700">← Plans</a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Plan: {{ $plan->name }}</h1>
    </div>

    @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('central.plans.update', $plan) }}" class="bg-white rounded-xl shadow p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan Name *</label>
                <input type="text" name="name" value="{{ old('name', $plan->name) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $plan->slug) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                <input type="number" name="price" value="{{ old('price', $plan->price) }}" min="0" step="0.01" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Billing Cycle *</label>
                <select name="billing_cycle" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) === 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max Bookings <span class="text-gray-400">(0 = unlimited)</span></label>
                <input type="number" name="max_bookings" value="{{ old('max_bookings', $plan->max_bookings ?? 0) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max Resources</label>
                <input type="number" name="max_resources" value="{{ old('max_resources', $plan->max_resources) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max Staff</label>
                <input type="number" name="max_staff" value="{{ old('max_staff', $plan->max_staff) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm font-medium text-gray-700">Active</span>
            </label>
        </div>

        {{-- Feature Toggles --}}
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Feature Flags</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($features as $feature)
                @php $checked = old('features.'.$feature->value, ($plan->features[$feature->value] ?? false)); @endphp
                <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" name="features[{{ $feature->value }}]" value="1"
                           {{ $checked ? 'checked' : '' }}
                           class="mt-0.5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $feature->label() }}</div>
                        <div class="text-xs text-gray-500">{{ $feature->description() }}</div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('central.plans.index') }}"
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                Update Plan
            </button>
        </div>
    </form>
</div>
</body>
</html>
