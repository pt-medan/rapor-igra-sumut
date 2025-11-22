@props([
    'nama' => '',
    'tanggal' => '',
    'href' => '',
])

<div class="px-6 py-3 hover:bg-gray-50 transition flex justify-between items-center" role="row">
    <div>
        <p class="text-sm font-semibold text-gray-900">{{ $nama }}</p>
        <p class="text-xs text-gray-500">{{ $tanggal }}</p>
    </div>
    @if($href)
        <a href="{{ $href }}" 
           title="Lihat detail untuk {{ $nama }}"
           aria-label="Lihat detail - {{ $nama }}"
           class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded hover:bg-blue-200 transition">
            Lihat
        </a>
    @endif
</div>
