<nav class="flex" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
    @foreach ($breadcrumbs as $item)
      <li class="inline-flex items-center">
        @isset($item['href'])
          <a href="{{ $item['href'] }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
            {{ $item['name'] }}
          </a>
        @else
          <span class="text-sm font-medium text-gray-500">{{ $item['name'] }}</span>
        @endisset
        @if (!$loop->last)
          <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
        @endif
      </li>
    @endforeach
  </ol>
</nav>
