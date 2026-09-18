@extends('layouts.main')

@section('page', 'dashboard')
@section('nav', 'dashboard')
@section('title', 'Dashboard · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Dashboard']]"
    title="Bienvenida de vuelta, Valentina"
    subtitle="Resumen general de la tienda — viernes, 18 de septiembre 2026">
    <x-slot:buttons>
      <button class="btn btn-light-outline no-print" onclick="window.print()"><i class="bi bi-printer me-2"></i>Imprimir</button>
      <a href="{{ route('productos.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Nuevo producto</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-sm-6 col-xl">
      <x-stat-card icon="bi-bag-heart" color="1" title="Ventas del día" value="$18,429" trend="+12.4%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl">
      <x-stat-card icon="bi-box-seam" color="2" title="Pedidos" value="137" trend="+8.1%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl">
      <x-stat-card icon="bi-people" color="3" title="Clientes activos" value="1,284" trend="+5.7%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl">
      <x-stat-card icon="bi-grid-1x2" color="4" title="Productos" value="486" trend="+3.2%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl">
      <x-stat-card icon="bi-wallet2" color="5" title="Ingresos del mes" value="$248,300" trend="-2.1%" :trend-up="false" />
    </div>
  </div>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-lg-8">
      <x-chart-card title="Ingresos y ventas" subtitle="Comparativa de los últimos 9 meses">
        <x-slot:headerActions>
          <button class="btn btn-soft btn-sm">12 meses</button>
          <button class="btn btn-light-outline btn-sm">30 días</button>
        </x-slot:headerActions>
        <x-slot:chart><canvas id="salesChart"></canvas></x-slot:chart>
      </x-chart-card>
    </div>
    <div class="col-12 col-lg-4">
      <x-chart-card title="Ventas por categoría" subtitle="Distribución del mes en curso" size="sm">
        <x-slot:chart><canvas id="categoryChart"></canvas></x-slot:chart>
      </x-chart-card>
    </div>
  </div>

  <x-data-table title="Ventas recientes" subtitle="Últimas transacciones registradas"
    :headers="[['label' => 'Venta'], ['label' => 'Fecha'], ['label' => 'Cliente'], ['label' => 'Método'], ['label' => 'Total'], ['label' => 'Estado'], ['label' => 'Acción', 'class' => 'text-end']]">
    <x-slot:headerActions>
      <a href="{{ route('ventas.index') }}" class="btn btn-light-outline btn-sm">Ver todas <i class="bi bi-arrow-right ms-1"></i></a>
    </x-slot:headerActions>
    <tbody id="recentSalesTable"></tbody>
  </x-data-table>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const D = window.APP_DATA;

    /* Tabla de ventas recientes */
    document.getElementById('recentSalesTable').innerHTML = D.sales.map(s =>
      '<tr>' +
      '<td class="fw-semibold" style="color:var(--primary)">' + s.id + '</td>' +
      '<td>' + s.date + '</td>' +
      '<td><div class="usr-cell"><span class="avatar-sm av-a">' + s.customer.split(' ').map(w => w[0]).join('').slice(0, 2) + '</span>' +
      '<span>' + s.customer + '</span></div></td>' +
      '<td>' + s.method + '</td>' +
      '<td class="fw-bold">' + fmt(s.total) + '</td>' +
      '<td>' + statusBadge(s.status) + '</td>' +
      '<td class="text-end"><a href="/ventas" class="btn btn-soft btn-sm">Detalle</a></td>' +
      '</tr>'
    ).join('');

    /* Gráfica de ingresos */
    const grad = (ctx, c1, c2) => {
      const g = ctx.createLinearGradient(0, 0, 0, 320);
      g.addColorStop(0, c1); g.addColorStop(1, c2);
      return g;
    };
    const sc = document.getElementById('salesChart');
    new Chart(sc, {
      type: 'line',
      data: {
        labels: D.salesChart.labels,
        datasets: [
          {
            label: 'Ventas (miles $)',
            data: D.salesChart.ventas,
            borderColor: '#7c5cf0',
            backgroundColor: grad(sc.getContext('2d'), 'rgba(124,92,240,.28)', 'rgba(124,92,240,0)'),
            fill: true, tension: .45, borderWidth: 3, pointRadius: 4,
            pointBackgroundColor: '#7c5cf0', pointBorderColor: '#fff', pointBorderWidth: 2
          },
          {
            label: 'Pedidos',
            data: D.salesChart.pedidos,
            borderColor: '#22c55e',
            backgroundColor: grad(sc.getContext('2d'), 'rgba(34,197,94,.18)', 'rgba(34,197,94,0)'),
            fill: true, tension: .45, borderWidth: 3, pointRadius: 4,
            pointBackgroundColor: '#22c55e', pointBorderColor: '#fff', pointBorderWidth: 2
          }
        ]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, padding: 18, font: { family: 'Inter', size: 12 } } }
        },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(124,92,240,.08)' }, border: { display: false }, ticks: { color: '#8a93ad' } },
          x: { grid: { display: false }, border: { display: false }, ticks: { color: '#8a93ad' } }
        }
      }
    });

    /* Gráfica de categorías */
    const cc = document.getElementById('categoryChart');
    new Chart(cc, {
      type: 'doughnut',
      data: {
        labels: D.categoryChart.labels,
        datasets: [{
          data: D.categoryChart.values,
          backgroundColor: ['#7c5cf0', '#b388ff', '#0ea5e9', '#22c55e', '#f59e0b', '#e9e4ff'],
          borderWidth: 3, borderColor: '#fff', hoverOffset: 8
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '68%',
        plugins: {
          legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 14, font: { family: 'Inter', size: 12 } } },
          tooltip: { callbacks: { label: c => ' ' + c.label + ': ' + c.parsed + '%' } }
        }
      }
    });
  });
</script>
@endpush