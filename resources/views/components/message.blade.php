@props(['message'])

@if(isset($message))
    <div class="border px-4 py-3 my-2 rounded relative bg-green-100 text-green-700">
        {{$message}}
    </div>
@endif