@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="px-4 py-3 my-2 rounded relative bg-red-100 border border-red-400 text-red-700">{{ $message }}</li>
        @endforeach
    </ul>
@endif
