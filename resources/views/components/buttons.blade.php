@props(['href' => null, 'variant' => 'btn-primary', 'icon' => null, 'size' => null, 'type' => 'button'])

@php
  $class = 'btn ' . $variant . ($size ? ' ' . $size : '');
@endphp

@if($href)
  <a href="{{ $href }}" class="{{ $class }}" {{ $attributes }}>
    @if($icon)<i class="bi {{ $icon }} me-2"></i>@endif{{ $slot }}
  </a>
@else
  <button type="{{ $type }}" class="{{ $class }}" {{ $attributes }}>
    @if($icon)<i class="bi {{ $icon }} me-2"></i>@endif{{ $slot }}
  </button>
@endif