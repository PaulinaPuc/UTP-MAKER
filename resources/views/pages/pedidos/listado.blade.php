@extends('layouts.main')

@section('page', 'pedidos')
@section('nav', 'pedidos')
@section('title', 'Pedidos · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Pedidos']]"
    title="Pedidos"
    subtitle="Administra el estado de cada pedido de la tienda">
    <x-slot:buttons>
      <button class="btn btn-primary" onclick="notify('primary','bi-plus-lg','Nuevo pedido desde el carrito')"><i class="bi bi-plus-lg me-2"></i>Nuevo pedido</button>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-6 col-xl-2"><div class="card p-3 text-center h-100"><div class="stat-title">Pendiente</div><div class="stat-value" style="font-size:22px;color:var(--primary)">18</div></div></div>
    <div class="col-6 col-xl-2"><div class="card p-3 text-center h-100"><div class="stat-title">Procesando</div><div class="stat-value" style="font-size:22px;color:var(--warning)">12</div></div></div>
    <div class="col-6 col-xl-2"><div class="card p-3 text-center h-100"><div class="stat-title">Enviado</div><div class="stat-value" style="font-size:22px;color:var(--info)">24</div></div></div>
    <div class="col-6 col-xl-2"><div class="card p-3 text-center h-100"><div class="stat-title">Entregado</div><div class="stat-value" style="font-size:22px;color:var(--success)">71</div></div></div>
    <div class="col-6 col-xl-2"><div class="card p-3 text-center h-100"><div class="stat-title">Cancelado</div><div class="stat-value" style="font-size:22px;color:var(--danger)">9</div></div></div>
    <div class="col-6 col-xl-2"><div class="card p-3 text-center h-100" style="background:linear-gradient(135deg,var(--primary),var(--violet));border:none"><div class="stat-title text-white-50">Total</div><div class="stat-value" style="font-size:22px;color:#fff">137</div></div></div>
  </div>

  <x-data-table title="Lista de pedidos"
    :headers="[['label' => 'Pedido'], ['label' => 'Fecha'], ['label' => 'Cliente'], ['label' => 'Artículos'], ['label' => 'Pago'], ['label' => 'Total'], ['label' => 'Estado'], ['label' => 'Acciones', 'class' => 'text-end']]">
    <x-slot:headerActions>
      <div class="filter-bar">
        <div style="position:relative">
          <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
          <input type="search" id="ordersSearch" class="search-input" style="padding-left:40px" placeholder="Buscar pedido...">
        </div>
        <select id="ordersFilter" class="form-select-clean">
          <option value="all">Todos los estados</option>
          <option value="pendiente">Pendiente</option>
          <option value="procesando">Procesando</option>
          <option value="enviado">Enviado</option>
          <option value="entregado">Entregado</option>
          <option value="cancelado">Cancelado</option>
        </select>
      </div>
    </x-slot:headerActions>
    <tbody id="ordersTable"></tbody>
  </x-data-table>

@endsection

@push('scripts')
<script>
  function renderOrders() {
    const q = (document.getElementById('ordersSearch').value || '').toLowerCase();
    const f = document.getElementById('ordersFilter').value;
    const data = window.APP_DATA.orders.filter(o =>
      (f === 'all' || o.status === f) &&
      (!q || o.customer.toLowerCase().includes(q) || o.id.toLowerCase().includes(q))
    );
    document.getElementById('ordersTable').innerHTML = data.length ? data.map(o => {
      const badge = { entregado: 'badge-g', enviado: 'badge-i', procesando: 'badge-w', pendiente: 'badge-p', cancelado: 'badge-d' }[o.status] || 'badge-o';
      const label = { entregado: 'Entregado', enviado: 'Enviado', procesando: 'Procesando', pendiente: 'Pendiente', cancelado: 'Cancelado' }[o.status] || o.status;
      return '<tr>' +
        '<td class="fw-semibold" style="color:var(--primary)">' + o.id + '</td>' +
        '<td>' + o.date + '</td>' +
        '<td><div class="usr-cell"><span class="avatar-sm av-' + ['a', 'c', 'e', 'f'][o.id % 4] + '">' + initials(o.customer) + '</span>' +
        '<span>' + o.customer + '</span></div></td>' +
        '<td>' + o.items + ' art.</td>' +
        '<td>' + o.method + '</td>' +
        '<td class="fw-bold">' + fmt(o.total) + '</td>' +
        '<td><span class="badge-soft ' + badge + '" id="st-' + o.id + '">' + label + '</span></td>' +
        '<td class="text-end">' +
        '<select class="form-select-clean d-inline-block" style="width:auto;padding:6px 10px;font-size:12.5px" onchange="changeOrderStatus(\'' + o.id + '\', this.value)">' +
        '<option value="pendiente" ' + (o.status === 'pendiente' ? 'selected' : '') + '>Pendiente</option>' +
        '<option value="procesando" ' + (o.status === 'procesando' ? 'selected' : '') + '>Procesando</option>' +
        '<option value="enviado" ' + (o.status === 'enviado' ? 'selected' : '') + '>Enviado</option>' +
        '<option value="entregado" ' + (o.status === 'entregado' ? 'selected' : '') + '>Entregado</option>' +
        '<option value="cancelado" ' + (o.status === 'cancelado' ? 'selected' : '') + '>Cancelado</option>' +
        '</select>' +
        '<button class="btn btn-soft btn-sm ms-1" onclick="viewOrder(\'' + o.id + '\')"><i class="bi bi-eye"></i></button>' +
        '</td></tr>';
    }).join('') : '<tr><td colspan="8" class="text-center text-muted-soft py-5">No hay pedidos que coincidan</td></tr>';
  }

  function changeOrderStatus(id, status) {
    const o = window.APP_DATA.orders.find(x => x.id === id);
    if (!o) return;
    o.status = status;
    const badge = { entregado: 'badge-g', enviado: 'badge-i', procesando: 'badge-w', pendiente: 'badge-p', cancelado: 'badge-d' }[status] || 'badge-o';
    const label = { entregado: 'Entregado', enviado: 'Enviado', procesando: 'Procesando', pendiente: 'Pendiente', cancelado: 'Cancelado' }[status] || status;
    const el = document.getElementById('st-' + id);
    if (el) { el.className = 'badge-soft ' + badge; el.textContent = label; }
    notify(status === 'cancelado' ? 'danger' : 'success', status === 'cancelado' ? 'bi-x-circle' : 'bi-arrow-repeat',
      'Pedido ' + id + ' → ' + label);
  }

  function viewOrder(id) {
    const o = window.APP_DATA.orders.find(x => x.id === id);
    if (o) notify('primary', 'bi-receipt', 'Pedido ' + o.id + ' · ' + o.customer + ' · ' + fmt(o.total));
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('ordersSearch').addEventListener('input', renderOrders);
    document.getElementById('ordersFilter').addEventListener('change', renderOrders);
    renderOrders();
  });
</script>
@endpush