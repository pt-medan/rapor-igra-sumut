@props(['items' => []])

<nav class="mb-3" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm">
        @foreach($items as $index => $item)
            @if($loop->last)
                <!-- Current page -->
                <li class="flex items-center">
                    @if(!$loop->first)
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    @endif
                    <span class="font-semibold text-gray-900" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                </li>
            @else
                <!-- Breadcrumb link -->
                <li class="flex items-center">
                    @if(!$loop->first)
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    @endif
                    <a href="{{ $item['url'] }}" class="text-gray-600 hover:text-indigo-600 hover:underline transition">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
