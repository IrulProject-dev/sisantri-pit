@props(['items'])

@foreach ($items as $item)
    @php
        $isActive = request()->routeIs($item['route'] . '*');
    @endphp
    <li>
        <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}"
            class="{{ $attributes->get('item-class', '') }} {{ $isActive ? $attributes->get('active-class', '') : $attributes->get('inactive-class', '') }}">
            @if (isset($item['icon']))
                <svg class="{{ $attributes->get('icon-class', '') }}" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    {!! $item['icon'] !!}
                </svg>
            @endif
            {{ $item['name'] }}
        </a>
    </li>
@endforeach
