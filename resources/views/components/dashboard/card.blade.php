@props([
    'title' => '',
    'icon' => null,
    'headerClass' => 'bg-gray-50',
    'animated' => false,
    'delay' => '0s'
])

@php
    $animationStyle = $animated ? "animation-delay: {$delay};" : '';
    $animationClass = $animated ? 'animate-fade-in-up' : '';
@endphp

<div class="bg-white rounded-lg shadow-md overflow-hidden {{ $animationClass }}" style="{{ $animationStyle }}">
    @if($title)
        <div class="px-6 py-4 {{ $headerClass }} border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                @if($icon)
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        {!! $icon !!}
                    </svg>
                @endif
                {{ $title }}
            </h3>
        </div>
    @endif
    
    <div class="divide-y divide-gray-200">
        {{ $slot }}
    </div>
</div>
