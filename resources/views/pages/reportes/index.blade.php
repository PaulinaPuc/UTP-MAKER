@extends('layouts.main')

@section('page', 'reportes')
@section('nav', 'reportes')
@section('title', 'Reportes · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Reportes']]"
    title="Reportes y analítica"
    subtitle="Indicadores clave y tendencias de tu negocio">
    <x-slot:buttons>
      <button class="btn btn-light-outline" onclick="notify('primary','bi-calendar-event','Generando reporte del período...', 4000)"><i class="bi bi-calendar-event me-2"></i>Programar</button>
      <button class="btn btn-primary" onclick="notify('success','bi-file-earmark-pdf','Reporte PDF generado correctamente')"><i class="bi bi-file-earmark-pdf me-2"></i>Exportar PDF</button>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-wallet2" color="1" title="Ingresos netos" value="$248,300" trend="+12.4% vs mes pasado" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-cart-check" color="2" title="Margen bruto" value="38.6%" trend="+2.1 pts" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-arrow-repeat" color="3" title="Ticket promedio" value="$1,204" trend="+5.8%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-arrow-repeat" color="4" title="Clientes nuevos" value="64" trend="+12.1%" :trend-up="true" />
    </div>
  </div>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-lg-7">
      <x-chart-card title="Ingresos acumulados" subtitle="Comportamiento anual">
        <x-slot:headerActions>
          <button class="btn btn-soft btn-sm">Anual</button>
          <button class="btn btn-light-outline btn-sm">Mensual</button>
        </x-slot:headerActions>
        <x-slot:chart><canvas id="reportBar"></canvas></x-slot:chart>
      </x-chart-card>
    </div>
    <div class="col-12 col-lg-5">
      <x-chart-card title="Desempeño de canales" subtitle="Ventas por canal de atención" size="sm">
        <x-slot:chart><canvas id="reportPie"></canvas></x-slot:chart>
      </x-chart-card>
    </div>
  </div>

  <x-data-table title="Top productos del mes" subtitle="Los más vendidos de septiembre"
    :headers="[['label' => '#'], ['label' => 'Producto'], ['label' => 'Categoría'], ['label' => 'Unidades'], ['label' => 'Ingresos'], ['label' => 'Tendencia']]">
    <x-slot:headerActions>
      <span class="badge-soft badge-p">Actualizado hoy</span>
    </x-slot:headerActions>
    <tr><td><span class="badge-soft badge-g">1</span></td>
      <td><div class="usr-cell"><span class="avatar-sm av-a">A</span><span class="fw-semibold">Audífonos Inalámbricos Aura</span></div></td>
      <td>Audio</td><td>326</td><td class="fw-bold">$488,674</td><td><span class="stat-trend up"><i class="bi bi-arrow-up-right"></i>32%</span></td></tr>
    <tr><td><span class="badge-soft badge-g">2</span></td>
      <td><div class="usr-cell"><span class="avatar-sm av-f">T</span><span class="fw-semibold">Teclado Mecánico Klip</span></div></td>
      <td>Tecnología</td><td>287</td><td class="fw-bold">$487,613</td><td><span class="stat-trend up"><i class="bi bi-arrow-up-right"></i>25%</span></td></tr>
    <tr><td><span class="badge-soft badge-p">3</span></td>
      <td><div class="usr-cell"><span class="avatar-sm av-b">P</span><span class="fw-semibold">Smartwatch Pulse Fit</span></div></td>
      <td>Tecnología</td><td>211</td><td class="fw-bold">$463,989</td><td><span class="stat-trend up"><i class="bi bi-arrow-up-right"></i>18%</span></td></tr>
    <tr><td><span class="badge-soft badge-p">4</span></td>
      <td><div class="usr-cell"><span class="avatar-sm av-g">C</span><span class="fw-semibold">Cafetera Ritual Barista</span></div></td>
      <td>Hogar</td><td>98</td><td class="fw-bold">$342,902</td><td><span class="stat-trend down"><i class="bi bi-arrow-down-right"></i>-5%</span></td></tr>
    <tr><td><span class="badge-soft badge-o">5</span></td>
      <td><div class="usr-cell"><span class="avatar-sm av-c">C</span><span class="fw-semibold">Camiseta Essential Soft</span></div></td>
      <td>Ropa</td><td>412</td><td class="fw-bold">$143,788</td><td><span class="stat-trend up"><i class="bi bi-arrow-up-right"></i>9%</span></td></tr>
  </x-data-table>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep'];
    const data = [141, 168, 155, 190, 175, 226, 214, 254, 248];
    const rb = document.getElementById('reportBar');
    new Chart(rb, {
      type: 'bar',
      data: {
        labels: months,
        datasets: [{
          label: 'Ingresos (miles $)',
          data,
          backgroundColor: 'rgba(124,92,240,.75)',
          hoverBackgroundColor: '#7c5cf0',
          borderRadius: 8, maxBarThickness: 38
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(124,92,240,.08)' }, border: { display: false }, ticks: { color: '#8a93ad' } },
          x: { grid: { display: false }, border: { display: false }, ticks: { color: '#8a93ad' } }
        }
      }
    });

    const rp = document.getElementById('reportPie');
    new Chart(rp, {
      type: 'doughnut',
      data: {
        labels: ['Tienda en línea', 'Punto de venta', 'WhatsApp', 'Marketplace'],
        datasets: [{
          data: [46, 28, 16, 10],
          backgroundColor: ['#7c5cf0', '#0ea5e9', '#22c55e', '#f59e0b'],
          borderWidth: 3, borderColor: '#fff', hoverOffset: 8
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '66%',
        plugins: {
          legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 14, font: { family: 'Inter', size: 12 } } },
          tooltip: { callbacks: { label: c => ' ' + c.label + ': ' + c.parsed + '%' } }
        }
      }
    });
  });
</script>
@endpush