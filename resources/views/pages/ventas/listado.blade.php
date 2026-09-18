@extends('layouts.main')

@section('page', 'ventas')
@section('nav', 'ventas')
@section('title', 'Ventas · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Ventas']]"
    title="Ventas"
    subtitle="Registro de todas las transacciones de la tienda">
    <x-slot:buttons>
      <button class="btn btn-light-outline" onclick="exportSales()"><i class="bi bi-download me-2"></i>Exportar CSV</button>
      <a href="{{ route('ventas.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Nueva venta</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-cart-check" color="1" title="Ventas totales" value="$248,300" trend="+9.4%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-receipt" color="2" title="Transacciones" value="1,847" trend="+6.2%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-hourglass-split" color="4" title="En proceso" value="23" trend="-3.8%" :trend-up="false" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-arrow-counterclockwise" color="5" title="Devoluciones" value="4.2%" trend="+0.5%" :trend-up="true" />
    </div>
  </div>

  <x-data-table title="Historial de ventas"
    :headers="[['label' => 'Venta'], ['label' => 'Fecha'], ['label' => 'Cliente'], ['label' => 'Método'], ['label' => 'Total'], ['label' => 'Estado'], ['label' => 'Acciones', 'class' => 'text-end']]">
    <x-slot:headerActions>
      <div class="filter-bar">
        <div style="position:relative">
          <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
          <input type="search" id="salesSearch" class="search-input" style="padding-left:40px" placeholder="Buscar venta o cliente...">
        </div>
        <select id="salesFilter" class="form-select-clean">
          <option value="all">Todos los estados</option>
          <option value="completada">Completada</option>
          <option value="pendiente">Pendiente</option>
          <option value="cancelada">Cancelada</option>
        </select>
      </div>
    </x-slot:headerActions>
    <tbody id="salesTable"></tbody>
  </x-data-table>

@endsection

@push('scripts')
<script>
  function renderSales() {
    const q = (document.getElementById('salesSearch').value || '').toLowerCase();
    const f = document.getElementById('salesFilter').value;
    const data = window.APP_DATA.sales.filter(s =>
      (f === 'all' || s.status === f) &&
      (!q || s.customer.toLowerCase().includes(q) || s.id.toLowerCase().includes(q))
    );
    document.getElementById('salesTable').innerHTML = data.length ? data.map(s =>
      '<tr>' +
      '<td class="fw-semibold" style="color:var(--primary)">' + s.id + '</td>' +
      '<td>' + s.date + '</td>' +
      '<td><div class="usr-cell"><span class="avatar-sm av-' + ['a', 'b', 'c', 'd'][s.id % 4] + '">' + initials(s.customer) + '</span>' +
      '<span>' + s.customer + '</span></div></td>' +
      '<td>' + s.method + '</td>' +
      '<td class="fw-bold">' + fmt(s.total) + '</td>' +
      '<td>' + statusBadge(s.status) + '</td>' +
      '<td class="text-end"><a class="btn btn-soft btn-sm" href="/ventas/' + encodeURIComponent(s.id) + '"><i class="bi bi-receipt me-1"></i>Detalle</a></td></tr>'
    ).join('') : '<tr><td colspan="7" class="text-center text-muted-soft py-5">No hay ventas que coincidan</td></tr>';
  }

  function exportSales() {
    const rows = [['Venta', 'Fecha', 'Cliente', 'Metodo', 'Total', 'Estado']];
    window.APP_DATA.sales.forEach(s => rows.push([s.id, s.date, s.customer, s.method, s.total, s.status]));
    const csv = rows.map(r => r.join(',')).join('\n');
    const a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'ventas.csv';
    a.click();
    notify('success', 'bi-download', 'Archivo exportado como ventas.csv');
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('salesSearch').addEventListener('input', renderSales);
    document.getElementById('salesFilter').addEventListener('change', renderSales);
    renderSales();
  });
</script>
@endpush