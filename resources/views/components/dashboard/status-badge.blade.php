@props(['status' => 'pending', 'label' => '', 'icon' => true])

@php
    $statusConfig = [
        'completed' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-700',
            'label' => 'Dinilai',
            'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />'
        ],
        'pending' => [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-700',
            'label' => 'Belum',
            'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.5a1 1 0 002 0V7zm0 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />'
        ]
    ];

    $config = $statusConfig[$status] ?? $statusConfig['pending'];
    $displayLabel = $label ?: $config['label'];
@endphp

<span class="px-2 py-1 {{ $config['bg'] }} {{ $config['text'] }} text-xs font-semibold rounded-full flex items-center justify-center gap-1 mx-auto w-fit" 
      title="Status: {{ $displayLabel }}" 
      aria-label="Status: {{ $displayLabel }}">
    @if($icon)
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            {!! $config['icon'] !!}
        </svg>
    @endif
    {{ $displayLabel }}
</span>
