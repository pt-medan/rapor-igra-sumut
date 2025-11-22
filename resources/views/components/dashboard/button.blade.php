@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'spinner' => false,
    'title' => '',
    'ariaLabel' => '',
    'href' => null,
    'type' => 'button',
    'disabled' => false
])

@php
    $variantClasses = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'secondary' => 'bg-gray-300 text-gray-700 hover:bg-gray-400',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];

    $sizeClasses = [
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = 'font-semibold rounded-lg transition flex items-center justify-center gap-2 min-h-[44px] sm:min-h-auto disabled:bg-gray-400 disabled:cursor-not-allowed';
    $variant = $variantClasses[$variant] ?? $variantClasses['primary'];
    $size = $sizeClasses[$size] ?? $sizeClasses['md'];
    $attributes = "{{ $variant }} {{ $size }} {{ $classes }}";
@endphp

@if($href)
    <a href="{{ $href }}" 
       {{ $attributes }}
       @if($title) title="{{ $title }}" @endif
       @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
       {{ $slot->attributes }}>
        @if($icon)
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                {!! $icon !!}
            </svg>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type }}" 
            {{ $attributes }}
            @if($title) title="{{ $title }}" @endif
            @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
            @if($disabled) disabled @endif
            {{ $slot->attributes }}>
        @if($icon && !$spinner)
            <svg class="w-4 h-4 icon-element" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                {!! $icon !!}
            </svg>
        @endif
        @if($spinner)
            <svg class="w-4 h-4 icon-element hidden animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
