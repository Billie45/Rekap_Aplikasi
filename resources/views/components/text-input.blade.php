{{-- @props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}> --}}

@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'border-2 border-blue-900 rounded-full px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400'
]) }}>

