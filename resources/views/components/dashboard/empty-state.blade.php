@props([
    'title' => 'Belum ada data',
    'description' => 'Mulai dengan membuat entri baru',
    'icon' => null,
    'actions' => []
])

<div class="space-y-4">
    <div class="text-center">
        @if($icon)
            <div class="mb-4 flex justify-center">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    {!! $icon !!}
                </svg>
            </div>
        @endif
        <p class="text-lg font-semibold text-gray-600">{{ $title }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
    </div>
    
    @if($actions && count($actions) > 0)
        <div class="flex justify-center gap-3 flex-wrap">
            @foreach($actions as $action)
                <a href="{{ $action['href'] }}" 
                   title="{{ $action['title'] ?? $action['label'] }}"
                   aria-label="{{ $action['aria-label'] ?? $action['label'] }}"
                   class="px-4 py-2 bg-{{ $action['variant'] ?? 'blue' }}-600 text-white rounded-lg font-semibold hover:bg-{{ $action['variant'] ?? 'blue' }}-700 transition text-sm flex items-center gap-2">
                    @if(isset($action['icon']))
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            {!! $action['icon'] !!}
                        </svg>
                    @endif
                    {{ $action['label'] }}
                </a>
            @endforeach
        </div>
    @endif
</div>
