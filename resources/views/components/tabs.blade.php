@props(['active'])

<div x-data="{ tab: '{{ $active }}' }">
    @if (isset($header))
        <div class="border-b border-gray-200 mb-6 overflow-x-auto">
            <ul class="flex flex-nowrap md:flex-wrap -mb-px text-sm font-medium text-center text-gray-500 m-0 p-0 list-none">
                {{ $header }}
            </ul>
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>
