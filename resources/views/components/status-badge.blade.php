@props(['status'])

@php
  $map = [
    'entregado' => ['badge-g', 'Entregado'],
    'enviado' => ['badge-i', 'Enviado'],
    'procesando' => ['badge-w', 'Procesando'],
    'pendiente' => ['badge-p', 'Pendiente'],
    'cancelado' => ['badge-d', 'Cancelado'],
    'completada' => ['badge-g', 'Completada'],
    'cancelada' => ['badge-d', 'Cancelada'],
    'activo' => ['badge-g', 'Activo'],
    'inactivo' => ['badge-d', 'Inactivo'],
  ];
  $m = $map[strtolower($status)] ?? ['badge-o', ucfirst($status)];
@endphp

<span class="badge-soft {{ $m[0] }}">{{ $m[1] }}</span>