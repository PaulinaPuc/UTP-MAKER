@extends('layouts.main')

@section('page', 'clientes')
@section('nav', 'clientes')
@section('title', 'Clientes · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Clientes']]"
    title="Clientes"
    subtitle="Gestiona tu base de clientes y su historial de compras">
    <x-slot:buttons>
      <a href="{{ route('clientes.create') }}" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Agregar cliente</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-people" color="3" title="Total de clientes" value="1,284" trend="+5.7%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-person-plus" color="1" title="Nuevos este mes" value="64" trend="+12.1%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-receipt" color="2" title="Clientes vip" value="96" trend="+4.3%" :trend-up="true" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-wallet2" color="5" title="Ticket promedio" value="$1,204" trend="-1.2%" :trend-up="false" />
    </div>
  </div>

  <x-data-table title="Directorio de clientes"
    :headers="[['label' => 'Cliente'], ['label' => 'Email'], ['label' => 'Teléfono'], ['label' => 'Pedidos'], ['label' => 'Total gastado'], ['label' => 'Última compra'], ['label' => 'Acciones', 'class' => 'text-end']]">
    <x-slot:headerActions>
      <div class="filter-bar">
        <div style="position:relative">
          <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
          <input type="search" id="customerSearch" class="search-input" style="padding-left:40px" placeholder="Buscar cliente...">
        </div>
        <select id="customerSort" class="form-select-clean">
          <option value="name">Ordenar: Nombre</option>
          <option value="total">Ordenar: Total gastado</option>
          <option value="orders">Ordenar: Pedidos</option>
        </select>
      </div>
    </x-slot:headerActions>
    <tbody id="customerTable"></tbody>
  </x-data-table>

  <x-modal id="customerModal" icon="bi-person-plus" title="Agregar nuevo cliente" hide-footer>
    <form id="customerForm">
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label-clean">Nombre completo *</label>
            <input type="text" class="form-control-clean w-100" required placeholder="Nombre y apellidos">
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label-clean">Email *</label>
            <input type="email" class="form-control-clean w-100" required placeholder="cliente@correo.com">
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label-clean">Teléfono</label>
            <input type="tel" class="form-control-clean w-100" placeholder="+52 55 ...">
          </div>
          <div class="col-12">
            <label class="form-label-clean">Dirección</label>
            <input type="text" class="form-control-clean w-100" placeholder="Calle, colonia, ciudad">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-outline" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Guardar cliente</button>
      </div>
    </form>
  </x-modal>

@endsection

@push('scripts')
<script>
  function renderCustomers() {
    const q = (document.getElementById('customerSearch').value || '').toLowerCase();
    const sort = document.getElementById('customerSort').value;
    let data = window.APP_DATA.customers.filter(c => !q || c.name.toLowerCase().includes(q) || c.email.toLowerCase().includes(q));
    data.sort((a, b) => sort === 'total' ? b.total - a.total : sort === 'orders' ? b.orders - a.orders : a.name.localeCompare(b.name));
    document.getElementById('customerTable').innerHTML = data.length ? data.map(c =>
      '<tr>' +
      '<td><div class="usr-cell"><span class="avatar-sm ' + c.avatar + '">' + initials(c.name) + '</span>' +
      '<div class="usr-meta"><strong>' + c.name + '</strong><span>ID #' + String(c.id).padStart(3, '0') + '</span></div></div></td>' +
      '<td>' + c.email + '</td>' +
      '<td>' + c.phone + '</td>' +
      '<td><span class="badge-soft badge-p">' + c.orders + ' pedidos</span></td>' +
      '<td class="fw-bold">' + fmt(c.total) + '</td>' +
      '<td>' + c.last + '</td>' +
      '<td class="text-end">' +
      '<a class="btn btn-soft btn-sm me-1" href="/clientes/' + c.id + '"><i class="bi bi-eye"></i></a>' +
      '<button class="btn btn-danger-soft btn-sm ms-1" onclick="notify(\'danger\',\'bi-trash\',\'Cliente eliminado\')"><i class="bi bi-trash"></i></button></td></tr>'
    ).join('') : '<tr><td colspan="7" class="text-center text-muted-soft py-5">No se encontraron clientes</td></tr>';
  }

  document.addEventListener('DOMContentLoaded', () => {
    const s = document.getElementById('customerSearch');
    s.addEventListener('input', renderCustomers);
    document.getElementById('customerSort').addEventListener('change', renderCustomers);
    document.getElementById('customerForm').addEventListener('submit', e => {
      e.preventDefault();
      bootstrap.Modal.getInstance(document.getElementById('customerModal')).hide();
      e.target.reset();
      notify('success', 'bi-check-circle', 'Cliente registrado correctamente');
    });
    renderCustomers();
  });
</script>
@endpush