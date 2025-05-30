@props(['items'])

<div x-data="{ openGroups: {} }" class="space-y-2">
    @foreach ($items as $item)
        @php
            $isGroup = $item['is_group'] ?? false;
            $groupId = md5($item['name']); // Generate unique ID untuk group
            $hasChildren = $isGroup && !empty($item['children']);
        @endphp

        @if ($isGroup)
            <div class="relative">
                {{-- Group Header --}}
                <button
                    type="button"
                    @click="openGroups['{{ $groupId }}'] = !openGroups['{{ $groupId }}']"
                    class="w-full flex items-center justify-between px-3 py-2.5 text-sm rounded-lg hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs(collect($item['children'])->pluck('route')->map(fn($r) => $r . '*')->toArray()) ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}"
                >
                    <div class="flex items-center space-x-3">
                        @if (isset($item['icon']))
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        @endif
                        <span>{{ $item['name'] }}</span>
                    </div>

                    {{-- Chevron Icon --}}
                    <svg
                        class="w-4 h-4 transform transition-transform duration-200"
                        :class="{ 'rotate-180': openGroups['{{ $groupId }}'] }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Children --}}
                <div
                    x-show="openGroups['{{ $groupId }}']"
                    x-collapse
                    class="ml-8 mt-1 space-y-2 border-l-2 border-blue-100 pl-3"
                >
                    @foreach ($item['children'] as $child)
                        @php
                            $isActive = request()->routeIs($child['route'] . '*');
                        @endphp
                        <a
                            href="{{ route($child['route']) }}"
                            class="flex items-center space-x-3 px-3 py-2 text-sm rounded-lg hover:bg-blue-50 transition-colors duration-200 {{ $isActive ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }}"
                        >
                            @if (isset($child['icon']))
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $child['icon'] !!}
                            </svg>
                            @endif
                            <span>{{ $child['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            @php
                $isActive = request()->routeIs($item['route'] . '*');
            @endphp
            <a
                href="{{ route($item['route']) }}"
                class="flex items-center space-x-3 px-3 py-2.5 text-sm rounded-lg hover:bg-blue-50 transition-colors duration-200 {{ $isActive ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}"
            >
                @if (isset($item['icon']))
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $item['icon'] !!}
                </svg>
                @endif
                <span>{{ $item['name'] }}</span>
            </a>
        @endif
    @endforeach
</div>
