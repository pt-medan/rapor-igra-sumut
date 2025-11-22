@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'options' => [],
    'value' => '',
    'title' => '',
    'ariaLabel' => '',
    'help' => '',
    'required' => false,
])

@php
    $selectId = $id ?: $name;
    $helpId = $selectId ? $selectId . '-help' : null;
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $selectId }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    
    <select 
        name="{{ $name }}"
        id="{{ $selectId }}"
        @if($title) title="{{ $title }}" @endif
        @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
        @if($helpId) aria-describedby="{{ $helpId }}" @endif
        @if($required) required @endif
        class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 min-h-[44px] sm:min-h-auto"
    >
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @if($value === (string)$optionValue) selected @endif>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    
    @if($help && $helpId)
        <small id="{{ $helpId }}" class="text-gray-500 text-xs mt-1 block">
            {{ $help }}
        </small>
    @endif
</div>
