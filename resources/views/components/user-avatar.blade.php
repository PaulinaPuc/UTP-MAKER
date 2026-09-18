@props(['name', 'color' => 'av-a', 'size' => 'sm'])

@php
  $words = preg_split('/\s+/', trim($name));
  $ini = implode('', array_slice(array_map(fn($w) => strtoupper(mb_substr($w, 0, 1)), $words), 0, 2));
@endphp

<span class="avatar{{ $size === 'sm' ? '-sm' : '' }} {{ $color }}">{{ $ini }}</span>