<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feature Matrix — Central Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('central.plans.index') }}" class="text-gray-500 hover:text-gray-700">← Plans</a>
        <h1 class="text-2xl font-bold text-gray-800">Feature Matrix</h1>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 bg-gray-50 sticky left-0">Feature</th>
                    @foreach($plans as $plan)
                    <th class="px-4 py-3 text-center font-semibold text-gray-700 min-w-[120px]">
                        {{ $plan->name }}
                        <div class="text-xs font-normal text-gray-400">${{ number_format($plan->price, 2) }}/{{ $plan->billing_cycle }}</div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($features as $feature)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-700 bg-white sticky left-0">
                        {{ $feature->label() }}
                        <div class="text-xs font-normal text-gray-400">{{ $feature->description() }}</div>
                    </td>
                    @foreach($plans as $plan)
                    <td class="px-4 py-3 text-center">
                        <form method="POST" action="{{ route('central.plans.update', $plan) }}">
                            @csrf
                            @method('PUT')
                            {{-- Pass all current plan data --}}
                            <input type="hidden" name="name" value="{{ $plan->name }}">
                            <input type="hidden" name="slug" value="{{ $plan->slug }}">
                            <input type="hidden" name="price" value="{{ $plan->price }}">
                            <input type="hidden" name="billing_cycle" value="{{ $plan->billing_cycle }}">
                            <input type="hidden" name="is_active" value="{{ $plan->is_active ? 1 : 0 }}">
                            {{-- Preserve all other features --}}
                            @foreach(\App\Enums\PlanFeature::cases() as $f)
                                @if($f !== $feature)
                                @php $fVal = $plan->features[$f->value] ?? false; @endphp
                                @if($fVal)
                                <input type="hidden" name="features[{{ $f->value }}]" value="1">
                                @endif
                                @endif
                            @endforeach
                            @php $isEnabled = $plan->features[$feature->value] ?? false; @endphp
                            @if(!$isEnabled)
                            <input type="hidden" name="features[{{ $feature->value }}]" value="1">
                            @endif
                            <button type="submit"
                                    class="w-6 h-6 rounded-full mx-auto flex items-center justify-center transition-colors
                                    {{ $isEnabled ? 'bg-green-500 hover:bg-red-400' : 'bg-gray-200 hover:bg-green-400' }}"
                                    title="{{ $isEnabled ? 'Click to disable' : 'Click to enable' }}">
                                @if($isEnabled)
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                                @else
                                <span class="text-gray-400 text-xs">−</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
