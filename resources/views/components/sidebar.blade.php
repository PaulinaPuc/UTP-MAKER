@props(['active' => 'dashboard'])

<aside class="sidebar">
  <div class="sidebar-brand">
    <span class="brand-ic"><i class="bi bi-bag-heart"></i></span>
    <span data-brand>Lavandia</span>
  </div>

  <div class="sidebar-section">Principal</div>
  <nav class="sidebar-nav">
    <a href="{{ route('dashboard') }}" class="sidebar-link @if($active === 'dashboard') active @endif">
      <i class="bi bi-grid"></i><span>Dashboard</span>
    </a>
    <a href="{{ route('productos.index') }}" class="sidebar-link @if($active === 'productos') active @endif">
      <i class="bi bi-box-seam"></i><span>Productos</span>
    </a>

    <div class="sidebar-section">Operación</div>
    <a href="{{ route('pedidos') }}" class="sidebar-link @if($active === 'pedidos') active @endif">
      <i class="bi bi-cart"></i><span>Pedidos</span><span class="badge-count">3</span>
    </a>
    <a href="{{ route('ventas.index') }}" class="sidebar-link @if($active === 'ventas') active @endif">
      <i class="bi bi-receipt"></i><span>Ventas</span>
    </a>
    <a href="{{ route('clientes.index') }}" class="sidebar-link @if($active === 'clientes') active @endif">
      <i class="bi bi-people"></i><span>Clientes</span>
    </a>
    <a href="{{ route('inventario') }}" class="sidebar-link @if($active === 'inventario') active @endif">
      <i class="bi bi-boxes"></i><span>Inventario</span>
    </a>

    <div class="sidebar-section">Análisis</div>
    <a href="{{ route('reportes') }}" class="sidebar-link @if($active === 'reportes') active @endif">
      <i class="bi bi-graph-up"></i><span>Reportes</span>
    </a>

    <div class="sidebar-section">Sistema</div>
    <a href="{{ route('configuracion') }}" class="sidebar-link @if($active === 'configuracion') active @endif">
      <i class="bi bi-gear"></i><span>Configuración</span>
    </a>
    <a href="{{ route('usuarios.index') }}" class="sidebar-link @if($active === 'usuarios') active @endif">
      <i class="bi bi-person-badge"></i><span>Usuarios</span>
    </a>
  </nav>
  <div id="sidebarProfile" style="padding:16px 20px"></div>
</aside>