@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'title' => '',
    'ariaLabel' => '',
    'help' => '',
    'required' => false,
])

@php
    $inputId = $id ?: $name;
    $helpId = $inputId ? $inputId . '-help' : null;
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($value) value="{{ $value }}" @endif
        @if($title) title="{{ $title }}" @endif
        @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
        @if($helpId) aria-describedby="{{ $helpId }}" @endif
        @if($required) required @endif
        class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 min-h-[44px] sm:min-h-auto"
    >
    
    @if($help && $helpId)
        <small id="{{ $helpId }}" class="text-gray-500 text-xs mt-1 block">
            {{ $help }}
        </small>
    @endif
</div>
