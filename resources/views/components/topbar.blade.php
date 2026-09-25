@props(['active' => 'dashboard'])

<header class="topbar">
  <button class="menu-toggle" aria-label="Menú"><i class="bi bi-list"></i></button>
  <div class="search-wrap">
    <i class="bi bi-search search-ic"></i>
    <input type="search" id="globalSearch" class="topbar-search" placeholder="Buscar productos, pedidos, clientes...">
  </div>
  <div class="topbar-actions">
    <a href="{{ route('ventas.create') }}" class="icon-btn" title="Carrito de compras">
      <i class="bi bi-bag"></i><span class="cart-count" style="display:none">0</span>
    </a>
    <div class="dropdown">
      <button class="icon-btn" data-bs-toggle="dropdown" data-bs-auto-close="outside" title="Notificaciones">
        <i class="bi bi-bell"></i><span class="dot"></span>
      </button>
      <div class="dropdown-menu dropdown-menu-end dropdown-menu-custom" style="width:330px">
        <div class="notif-title d-flex justify-content-between align-items-center">Notificaciones
          <a href="#" class="small" style="font-size:12px">Marcar leídas</a>
        </div>
        <div id="notifList"></div>
      </div>
    </div>
    <div class="dropdown">
      <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="avatar" data-userinitials>VR</span>
        <span class="avatar-text"><strong data-username>Valentina Ríos</strong><span data-userrole>Administradora</span></span>
        <i class="bi bi-chevron-down" style="font-size:11px;color:var(--muted)"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-end dropdown-menu-custom" style="width:240px">
        <div class="px-3 py-2"><strong data-username>Valentina Ríos</strong><div class="small text-muted-soft" data-useremail>valentina@lavandia.shop</div></div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('configuracion') }}"><i class="bi bi-gear me-1"></i>Configuración</a>
        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('reportes') }}"><i class="bi bi-file-earmark-bar-graph me-1"></i>Reportes</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="{{ route('login') }}"><i class="bi bi-box-arrow-right me-1"></i>Cerrar sesión</a>
      </div>
    </div>
  </div>
</header>