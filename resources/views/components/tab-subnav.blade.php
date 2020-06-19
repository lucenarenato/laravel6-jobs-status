<div class="sm:hidden" x-data="{}">
    <select
        aria-label="Selected tab"
        class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150"
        x-on:change="window.location.href = $event.target.value">
            @foreach ($items as $label => $url)
                <option value="{{ $url['url'] ?? $url }}" :selected="window.location.href.startsWith('{{ $url['url'] ?? $url }}')">{{ $url['label'] ?? $label }}</option>
            @endforeach
    </select>
</div>
<div class="hidden sm:block">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
            @foreach ($items as $label => $url)
                <x-tab-item :href="$url['url'] ?? $url" :exact="$url['exact'] ?? null">{{ $url['label'] ?? $label }}</x-tab-item>
            @endforeach
        </nav>
    </div>
</div>
