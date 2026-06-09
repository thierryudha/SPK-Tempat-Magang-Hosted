@props(['links' => []])

<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-2">
        <li class="inline-flex items-center">
            <a href="{{ request()->is('admin*') ? route('admin.dashboard') : route('dashboard') }}" class="inline-flex items-center text-[12px] font-bold text-[#94A3B8] uppercase tracking-wider hover:text-[#2563EB] transition-colors">
                <i class="ti ti-smart-home mr-1.5 text-[14px]"></i>
                Dashboard
            </a>
        </li>
        @foreach($links as $link)
        <li class="flex items-center">
            <i class="ti ti-chevron-right text-[#94A3B8] text-[12px] mx-1"></i>
            @if(isset($link['url']))
                <a href="{{ $link['url'] }}" class="text-[12px] font-bold text-[#94A3B8] uppercase tracking-wider hover:text-[#2563EB] transition-colors">{{ $link['label'] }}</a>
            @else
                <span class="text-[12px] font-bold text-[#2563EB] uppercase tracking-wider">{{ $link['label'] }}</span>
            @endif
        </li>
        @endforeach
    </ol>
</nav>
