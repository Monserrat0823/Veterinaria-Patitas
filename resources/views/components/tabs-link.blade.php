@props(['tab', 'error' => false])

<li class="mr-2 flex-shrink-0 list-none" role="presentation">
    <button type="button" @click="tab = '{{ $tab }}'"
       :class="{
           'text-red-600 border-red-600 font-bold border-b-2': {{ $error ? 'true' : 'false' }} && tab !== '{{ $tab }}',
           'text-blue-600 border-blue-600 font-bold border-b-2': tab === '{{ $tab }}' && !{{ $error ? 'true' : 'false' }},
           'text-red-600 border-red-600 font-bold border-b-2': tab === '{{ $tab }}' && {{ $error ? 'true' : 'false' }},
           'text-gray-500 border-transparent hover:text-blue-600 hover:border-gray-300 border-b-2': tab !== '{{ $tab }}' && !{{ $error ? 'true' : 'false' }},
       }"
       class="inline-flex items-center gap-2 py-3 px-5 text-sm font-medium transition-all whitespace-nowrap outline-none focus:outline-none {{ $error ? 'text-red-600 border-red-600 font-bold' : '' }}"
       :aria-current="tab === '{{ $tab }}' ? 'page' : undefined">
       {{ $slot }}
       @if ($error)
           <i class="fas fa-exclamation-circle ml-2 text-red-500 animate-pulse"></i>
       @endif
    </button>
</li>
