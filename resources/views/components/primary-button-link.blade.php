<a
    {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center px-4 py-2 rounded-md font-bold text-xs text-white 
                            bg-gray-800 border border-transparent 
                            hover:bg-gray-700 
                            active:bg-gray-900 transition ease-in-out duration-150',
    ]) }}>
    <span>{{ $slot }}</span>
</a>
