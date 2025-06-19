@props([
    'type' => 'info', // Default type: 'info', 'success', 'error', 'warning'
    'message' => '',
    // Additional classes are automatically merged via $attributes
])

@php
    // Base classes for all alert types
    $baseClasses = 'border-l-4 p-4 flex items-center space-x-3 rtl:space-x-reverse rounded-md shadow-sm';

    // Type-specific classes and icons
    $typeSpecificClasses = '';
    $iconSvg = ''; // SVG code for the icon

    switch ($type) {
        case 'success':
            $typeSpecificClasses =
                'bg-green-50 border-green-500 text-green-700';
            // Heroicon: check-circle
            $iconSvg =
                '<svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>';
            break;
        case 'error':
            $typeSpecificClasses =
                'bg-red-50 border-red-500 text-red-700';
            // Heroicon: x-circle
            $iconSvg =
                '<svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
            break;
        case 'warning':
            $typeSpecificClasses =
                'bg-yellow-50 border-yellow-500 text-yellow-700 ';
            // Heroicon: exclamation-triangle
            $iconSvg =
                '<svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.485 2.495c.646-1.133 2.384-1.133 3.03 0l6.28 10.975c.666 1.167-.173 2.608-1.516 2.608H3.72c-1.343 0-2.182-1.441-1.515-2.608l6.28-10.975zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>';
            break;
        case 'info':
        default:
            // Default to 'info'
            $typeSpecificClasses =
                'bg-blue-50 border-blue-500 text-blue-700';
            // Heroicon: information-circle
            $iconSvg =
                '<svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>';
            break;
    }
@endphp

@if (!empty($message))
    <div {{ $attributes->merge(['class' => $baseClasses . ' ' . $typeSpecificClasses]) }} role="alert">
        @if ($iconSvg)
            <span class="text-current"> {{-- Icon inherits text color from parent for consistency --}}
                {!! $iconSvg !!}
            </span>
        @endif
        <p class="text-sm font-medium flex-1">
            {{ $message }}
        </p>

        {{ $slot }}
    </div>
@endif
