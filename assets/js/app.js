/* ============================================================
   SISTEMA DE VENTAS · Lógica compartida
   Carrito · Notificaciones · Utilidades · Navegación
   La estructura (sidebar/topbar) se renderiza en Blade/Laravel.
   ============================================================ */

const Store = {
  KEY: 'lavandia_cart',
  COUPONS: { 'LAVANDIA10': 10, 'BIENVENIDO15': 15, 'VIP20': 20 },

  getCart() {
    try {
      return JSON.parse(localStorage.getItem(this.KEY)) || [];
    } catch (e) { return []; }
  },
  saveCart(cart) {
    localStorage.setItem(this.KEY, JSON.stringify(cart));
    this.refreshCartBadge();
  },
  add(productId, qty = 1) {
    const cart = this.getCart();
    const found = cart.find(i => i.id === productId);
    if (found) found.qty += qty;
    else cart.push({ id: productId, qty });
    this.saveCart(cart);
    notify('success', 'bi-check-circle', 'Producto agregado al carrito');
  },
  remove(productId) {
    const cart = this.getCart().filter(i => i.id !== productId);
    this.saveCart(cart);
    notify('danger', 'bi-trash', 'Producto eliminado del carrito');
  },
  setQty(productId, qty) {
    const cart = this.getCart();
    const found = cart.find(i => i.id === productId);
    if (!found) return;
    found.qty = Math.max(1, Math.min(qty, 99));
    this.saveCart(cart);
  },
  count() {
    return this.getCart().reduce((n, i) => n + i.qty, 0);
  },
  refreshCartBadge() {
    document.querySelectorAll('.cart-count').forEach(el => {
      const c = this.count();
      el.textContent = c;
      el.style.display = c > 0 ? 'grid' : 'none';
    });
  },
  /* -- Calculo de compra: subtotal, descuento y total -- */
  getTotals(applyCoupon) {
    const items = this.getCart();
    const subtotal = items.reduce((s, i) => {
      const p = window.APP_DATA.products.find(x => x.id === i.id);
      return s + ((p ? p.price : 0) * i.qty);
    }, 0);
    let discount = 0, couponName = null;
    if (applyCoupon && this.COUPONS[String(applyCoupon).toUpperCase()]) {
      discount = subtotal * (this.COUPONS[String(applyCoupon).toUpperCase()] / 100);
      couponName = String(applyCoupon).toUpperCase();
    }
    const shipping = subtotal === 0 ? 0 : (subtotal >= 3000 ? 0 : 120);
    const total = subtotal - discount + shipping;
    return { subtotal, discount, shipping, total, couponName, itemCount: items.reduce((n, i) => n + i.qty, 0) };
  }
};

/* ---------- Utilidades ---------- */

function fmt(n) {
  return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: 0 }).format(n);
}

function imgPath(img) {
  return (img || '').startsWith('data:') || (img || '').indexOf('/') > -1 ? img : '/assets/img/products/' + img;
}

function stars(rating) {
  let s = '<span class="rate-stars">';
  for (let i = 1; i <= 5; i++) s += i <= Math.round(rating) ? '\u2605' : '\u2606';
  return s + '</span>';
}

function topRated(value, label) {
  return '<span class="badge-soft ' + (label === 1 ? 'badge-g' : label === 2 ? 'badge-w' : label === 3 ? 'badge-d' : 'badge-i') + '">' + value + '</span>';
}

function statusBadge(status) {
  const map = {
    'entregado': ['badge-g', 'Entregado'],
    'enviado': ['badge-i', 'Enviado'],
    'procesando': ['badge-w', 'Procesando'],
    'pendiente': ['badge-p', 'Pendiente'],
    'cancelado': ['badge-d', 'Cancelado'],
    'completada': ['badge-g', 'Completada'],
    'cancelada': ['badge-d', 'Cancelada']
  };
  const m = map[status] || ['badge-o', status];
  return '<span class="badge-soft ' + m[0] + '">' + m[1] + '</span>';
}

function stockInfo(stock, min = 10) {
  if (stock <= 0) return '<span class="p-stock out"><i class="bi bi-x-circle me-1"></i>Sin stock</span>';
  if (stock <= min) return '<span class="p-stock low"><i class="bi bi-exclamation-triangle me-1"></i>Stock bajo (' + stock + ')</span>';
  return '<span class="p-stock ok"><i class="bi bi-check-circle me-1"></i>' + stock + ' disponibles</span>';
}

function initials(name) {
  return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
}

/* ---------- Notificaciones (toast) ---------- */

function ensureToastZone() {
  let zone = document.querySelector('.toast-zone');
  if (!zone) {
    zone = document.createElement('div');
    zone.className = 'toast-zone';
    document.body.appendChild(zone);
  }
  return zone;
}

function notify(type, icon, message, ms = 3200) {
  const zone = ensureToastZone();
  const colors = { success: 'success', danger: 'danger', warning: 'warning', primary: '' };
  const icons = {
    success: 'bi-check-circle', danger: 'bi-x-circle', warning: 'bi-exclamation-triangle',
    primary: 'bi-info-circle'
  };
  const el = document.createElement('div');
  el.className = 'toast-custom ' + (colors[type] || '');
  el.innerHTML =
    '<span class="t-ic ' + (type === 'success' ? 'bg-s bg' : type === 'danger' ? 'bg-d bg' : type === 'warning' ? 'bg-w bg' : 'bg bg') + '"><i class="bi ' + (icon || icons[type]) + '"></i></span>' +
    '<div>' + message + '</div>' +
    '<button class="close-toast"><i class="bi bi-x-lg"></i></button>';
  zone.appendChild(el);
  const remove = () => { el.style.opacity = '0'; el.style.transition = 'opacity .3s'; setTimeout(() => el.remove(), 300); };
  el.querySelector('.close-toast').addEventListener('click', remove);
  setTimeout(remove, ms);
}

/* ---------- Sidebar móvil ---------- */

function setupSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const backdrop = document.querySelector('.sidebar-backdrop');
  const toggle = document.querySelector('.menu-toggle');
  if (!sidebar || !toggle) return;
  const close = () => { sidebar.classList.remove('open'); if (backdrop) backdrop.classList.remove('show'); };
  toggle.addEventListener('click', () => {
    if (sidebar.classList.contains('open')) close();
    else { sidebar.classList.add('open'); if (backdrop) backdrop.classList.add('show'); }
  });
  if (backdrop) backdrop.addEventListener('click', close);
}

/* ---------- Topbar común ---------- */

function loadCommon() {
  const D = window.APP_DATA;
  const user = D.user;

  /* Rellenar datos del usuario y la tienda */
  document.querySelectorAll('[data-username]').forEach(el => {
    el.textContent = user.name;
  });
  document.querySelectorAll('[data-userrole]').forEach(el => {
    el.textContent = user.role;
  });
  document.querySelectorAll('[data-userinitials]').forEach(el => {
    el.textContent = user.initials;
  });
  document.querySelectorAll('[data-useremail]').forEach(el => {
    el.textContent = user.email;
  });
  document.querySelectorAll('[data-brand]').forEach(el => {
    el.textContent = D.store.name;
  });

  /* Notificaciones dropdown */
  const notifList = document.getElementById('notifList');
  if (notifList) {
    notifList.innerHTML = D.notifications.map(n => {
      const cls = n.type === 'success' ? 'bg-s' : n.type === 'danger' ? 'bg-d' : n.type === 'warning' ? 'bg-w' : 'bg';
      return '<div class="notif-item">' +
        '<span class="n-ic ' + cls + '"><i class="bi ' + n.icon + '"></i></span>' +
        '<div><p>' + n.text + '</p><span>' + n.time + '</span></div>' +
        '</div>';
    }).join('') +
      '<div class="text-center pt-2"><a href="/pedidos" class="btn btn-sm btn-soft w-100">Ver todas las notificaciones</a></div>';
  }

  /* Perfil del sidebar */
  const sbProfile = document.getElementById('sidebarProfile');
  if (sbProfile) {
    sbProfile.innerHTML =
      '<div class="d-flex align-items-center gap-3 px-2">' +
      '<span class="avatar-sm av-a" style="width:42px;height:42px;border-radius:12px">' + user.initials + '</span>' +
      '<div class="flex-grow-1"><strong class="d-block" style="font-size:13.5px">' + user.name + '</strong>' +
      '<span style="font-size:12px;color:var(--muted)">' + user.role + '</span></div>' +
      '<a href="/configuracion" style="color:var(--muted)"><i class="bi bi-sliders"></i></a></div>';
  }

  /* Buscador global: navega a productos */
  const globalSearch = document.getElementById('globalSearch');
  if (globalSearch) {
    globalSearch.addEventListener('keydown', e => {
      if (e.key === 'Enter' && globalSearch.value.trim()) {
        window.location.href = '/productos?q=' + encodeURIComponent(globalSearch.value.trim());
      }
    });
  }

  Store.refreshCartBadge();
  setupSidebar();
}

/* ---------- Query params ---------- */

function getQueryParam(name) {
  return new URLSearchParams(window.location.search).get(name);
}

/* ---------- Cargar productos en grid ---------- */

function renderProductGrid(containerId, filter) {
  const box = document.getElementById(containerId);
  if (!box) return;
  const data = window.APP_DATA.products;
  box.innerHTML = data.map(p => {
    const stock = p.stock <= 0 ? '<span class="p-stock out"><i class="bi bi-x-circle me-1"></i>Sin stock</span>'
      : p.stock <= 10 ? '<span class="p-stock low"><i class="bi bi-exclamation-triangle me-1"></i>Stock bajo (' + p.stock + ')</span>'
        : '<span class="p-stock ok"><i class="bi bi-check-circle me-1"></i>' + p.stock + ' disponibles</span>';
    return '<div class="p-card" data-id="' + p.id + '">' +
      '<div class="p-img-wrap">' +
      (p.oldPrice ? '<span class="p-badge badge-soft badge-p">-' + Math.round((1 - p.price / p.oldPrice) * 100) + '%</span>' : '') +
      '<img src="' + imgPath(p.img) + '" alt="' + p.name + '" class="p-img" loading="lazy">' +
      '<div class="p-actions">' +
      '<button title="Ver" onclick="location.href=\'/productos/' + p.id + '\'"><i class="bi bi-eye"></i></button>' +
      '<button title="Agregar al carrito" onclick="Store.add(' + p.id + ')"><i class="bi bi-cart-plus"></i></button>' +
      '<button title="Editar" onclick="location.href=\'/productos/' + p.id + '/editar\'"><i class="bi bi-pencil"></i></button>' +
      '<button title="Eliminar" onclick="deleteProduct(' + p.id + ')"><i class="bi bi-trash"></i></button>' +
      '</div></div>' +
      '<div class="p-body">' +
      '<div class="p-cat">' + p.category + '</div>' +
      '<div class="p-name">' + p.name + '</div>' +
      '<div>' + stars(p.rating) + ' <span class="p-rate">' + p.rating + '</span></div>' +
      '<div class="p-foot">' +
      '<div class="p-price">' + fmt(p.price) + (p.oldPrice ? '<span class="old">' + fmt(p.oldPrice) + '</span>' : '') + '</div>' +
      '<button class="btn btn-soft btn-sm" onclick="Store.add(' + p.id + ')" style="padding:7px 14px"><i class="bi bi-cart-plus"></i></button>' +
      '</div>' +
      '<div>' + stock + '</div>' +
      '</div></div>';
  }).join('');
}

/* ---------- Eliminación de productos ---------- */

function deleteProduct(id) {
  const p = window.APP_DATA.products.find(x => x.id === id);
  const modal = document.getElementById('deleteConfirmModal');
  if (modal) {
    document.getElementById('deleteProductName').textContent = p ? p.name : 'este producto';
    const btn = modal.querySelector('#confirmDeleteBtn');
    btn.onclick = () => {
      window.APP_DATA.products = window.APP_DATA.products.filter(x => x.id !== id);
      window.applyProductFilters ? window.applyProductFilters() : renderProductGrid('productGrid');
      const im = bootstrap.Modal.getInstance(modal);
      if (im) im.hide();
      notify('success', 'bi-check-circle', 'Producto eliminado correctamente');
    };
    bootstrap.Modal.getOrCreateInstance(modal).show();
  } else {
    window.APP_DATA.products = window.APP_DATA.products.filter(x => x.id !== id);
    window.applyProductFilters ? window.applyProductFilters() : renderProductGrid('productGrid');
    notify('success', 'bi-check-circle', 'Producto eliminado correctamente');
  }
}

/* ---------- Modal agregar / editar producto ---------- */

function openProductModal(id) {
  const D = window.APP_DATA;
  const p = id ? D.products.find(x => x.id === id) : null;
  const form = document.getElementById('productForm');
  const modalTitle = document.getElementById('productModalTitle');
  const iconLabel = document.querySelector('#productModal .modal-title-ic i');
  modalTitle.textContent = p ? 'Editar producto' : 'Agregar nuevo producto';
  iconLabel.className = 'bi ' + (p ? 'bi-pencil-square' : 'bi-plus-lg');

  document.getElementById('p-id').value = p ? p.id : '';
  document.getElementById('p-name').value = p ? p.name : '';
  document.getElementById('p-category').value = p ? p.category : D.categories[0];
  document.getElementById('p-price').value = p ? p.price : '';
  document.getElementById('p-oldPrice').value = p ? (p.oldPrice || '') : '';
  document.getElementById('p-stock').value = p ? p.stock : '';
  document.getElementById('p-desc').value = p ? p.desc : '';

  form.onsubmit = (e) => {
    e.preventDefault();
    const data = {
      name: document.getElementById('p-name').value.trim(),
      category: document.getElementById('p-category').value,
      price: parseFloat(document.getElementById('p-price').value) || 0,
      oldPrice: parseFloat(document.getElementById('p-oldPrice').value) || 0,
      stock: parseInt(document.getElementById('p-stock').value) || 0,
      desc: document.getElementById('p-desc').value.trim(),
      rating: p ? p.rating : (4 + Math.round(Math.random() * 8) / 10),
      img: p ? p.img : 'p' + (D.products.length + 1) + '.svg'
    };
    if (p) { Object.assign(p, data); }
    else { data.id = Date.now(); D.products.unshift(data); }
    window.applyProductFilters ? window.applyProductFilters() : renderProductGrid('productGrid');
    const im = bootstrap.Modal.getInstance(document.getElementById('productModal'));
    if (im) im.hide();
    notify('success', 'bi-check-circle', p ? 'Producto actualizado' : 'Producto creado correctamente');
  };

  const select = document.getElementById('p-category');
  select.innerHTML = D.categories.map(c => '<option value="' + c + '">' + c + '</option>').join('');
  select.value = p ? p.category : D.categories[0];
}

/* ---------- Formulario standalone crear / editar producto ---------- */

function initStandaloneProductForm() {
  const form = document.getElementById('productForm');
  if (!form) return;
  const D = window.APP_DATA;
  const page = document.body.getAttribute('data-page') || '';
  const isEdit = page === 'productos.editar';
  const seg = window.location.pathname.split('/').filter(Boolean);
  const id = isEdit && seg.length >= 3 ? parseInt(seg[seg.length - 2], 10) : null;
  const p = isEdit && id ? D.products.find(x => x.id === id) : null;

  const select = document.getElementById('p-category');
  select.innerHTML = D.categories.map(c => '<option value="' + c + '">' + c + '</option>').join('');

  document.getElementById('p-name').value = p ? p.name : '';
  document.getElementById('p-category').value = p ? p.category : D.categories[0];
  document.getElementById('p-price').value = p ? p.price : '';
  document.getElementById('p-oldPrice').value = p ? (p.oldPrice || '') : '';
  document.getElementById('p-stock').value = p ? p.stock : '';
  document.getElementById('p-desc').value = p ? p.desc : '';

  form.onsubmit = (e) => {
    e.preventDefault();
    const data = {
      name: document.getElementById('p-name').value.trim(),
      category: document.getElementById('p-category').value,
      price: parseFloat(document.getElementById('p-price').value) || 0,
      oldPrice: parseFloat(document.getElementById('p-oldPrice').value) || 0,
      stock: parseInt(document.getElementById('p-stock').value) || 0,
      desc: document.getElementById('p-desc').value.trim(),
      rating: p ? p.rating : (4 + Math.round(Math.random() * 8) / 10),
      img: p ? p.img : 'p' + (D.products.length + 1) + '.svg'
    };
    if (p) { Object.assign(p, data); }
    else { data.id = Date.now(); D.products.unshift(data); }
    notify('success', 'bi-check-circle', p ? 'Producto actualizado' : 'Producto creado correctamente');
    setTimeout(() => { window.location.href = '/productos'; }, 900);
  };
}

/* ---------- Filtrado de productos ---------- */

function setupProductFilters() {
  const search = document.getElementById('productSearch');
  const cat = document.getElementById('productCategory');
  if (!search && !cat) return;
  const apply = () => {
    const q = (search ? search.value : '').toLowerCase().trim();
    const c = cat ? cat.value : 'all';
    const data = window.APP_DATA.products.filter(p =>
      (!q || p.name.toLowerCase().includes(q) || p.category.toLowerCase().includes(q)) &&
      (c === 'all' || p.category === c)
    );
    const box = document.getElementById('productGrid');
    box.innerHTML = data.map(p => {
      return '<div class="p-card" data-id="' + p.id + '">' +
        '<div class="p-img-wrap">' +
        '<img src="' + imgPath(p.img) + '" alt="' + p.name + '" class="p-img" loading="lazy">' +
        '<div class="p-actions">' +
        '<button title="Ver" onclick="location.href=\'/productos/' + p.id + '\'"><i class="bi bi-eye"></i></button>' +
        '<button title="Agregar" onclick="Store.add(' + p.id + ')"><i class="bi bi-cart-plus"></i></button>' +
        '<button title="Editar" onclick="location.href=\'/productos/' + p.id + '/editar\'"><i class="bi bi-pencil"></i></button>' +
        '<button title="Eliminar" onclick="deleteProduct(' + p.id + ')"><i class="bi bi-trash"></i></button>' +
        '</div></div>' +
        '<div class="p-body"><div class="p-cat">' + p.category + '</div>' +
        '<div class="p-name">' + p.name + '</div>' +
        '<div>' + stars(p.rating) + ' <span class="p-rate">' + p.rating + '</span></div>' +
        '<div class="p-foot"><div class="p-price">' + fmt(p.price) + (p.oldPrice ? '<span class="old">' + fmt(p.oldPrice) + '</span>' : '') + '</div>' +
        '<button class="btn btn-soft btn-sm" onclick="Store.add(' + p.id + ')" style="padding:7px 14px"><i class="bi bi-cart-plus"></i></button></div>' +
        '<div>' + stockInfo(p.stock) + '</div></div></div>';
    }).join('');
    const empty = document.getElementById('productEmpty');
    if (empty) empty.style.display = data.length ? 'none' : 'block';
    const count = document.getElementById('productCount');
    if (count) count.textContent = data.length;
  };
  if (search) search.addEventListener('input', apply);
  if (cat) cat.addEventListener('change', apply);
  window.applyProductFilters = apply;
  apply();
}

/* ---------- Carrito: render completo ---------- */

function renderCart() {
  const items = Store.getCart();
  const box = document.getElementById('cartItems');
  const empty = document.getElementById('cartEmpty');
  const wrap = document.getElementById('cartWrap');

  if (!box) return;
  if (wrap) wrap.style.display = items.length ? '' : 'none';
  if (empty) empty.style.display = items.length ? 'none' : '';

  box.innerHTML = items.map(i => {
    const p = window.APP_DATA.products.find(x => x.id === i.id) ||
      { name: 'Producto', category: 'General', price: 0, img: 'p1.svg' };
    return '<div class="cart-item">' +
      '<div class="ci-img"><img src="' + imgPath(p.img) + '" alt="' + p.name + '"></div>' +
      '<div class="ci-info">' +
      '<div class="ci-name">' + p.name + '</div>' +
      '<div class="ci-cat">' + p.category + '</div>' +
      '<div class="ci-price mt-1">' + fmt(p.price) + '</div>' +
      '</div>' +
      '<div class="d-flex align-items-center gap-2">' +
      '<button class="qty-btn" onclick="changeQty(' + p.id + ',-1)"><i class="bi bi-dash"></i></button>' +
      '<span class="fw-bold" style="min-width:34px;text-align:center" id="qty-' + p.id + '">' + i.qty + '</span>' +
      '<button class="qty-btn" onclick="changeQty(' + p.id + ',1)"><i class="bi bi-plus"></i></button>' +
      '</div>' +
      '<div class="ci-total">' + fmt(p.price * i.qty) + '</div>' +
      '<button class="btn btn-danger-soft" style="width:38px;height:38px;padding:0" title="Eliminar" onclick="Store.remove(' + p.id + '); renderCart();"><i class="bi bi-trash"></i></button>' +
      '</div>';
  }).join('');

  updateSummary();
}

function changeQty(id, delta) {
  const items = Store.getCart();
  const found = items.find(i => i.id === id);
  if (!found) return;
  const q = found.qty + delta;
  if (q <= 0) { Store.remove(id); renderCart(); return; }
  Store.setQty(id, q);
  const el = document.getElementById('qty-' + id);
  if (el) el.textContent = q;
  updateSummary();
}

let activeCoupon = null;

function updateSummary() {
  const totals = Store.getTotals(activeCoupon);
  const subtotalEl = document.getElementById('cartSubtotal');
  const discountEl = document.getElementById('cartDiscount');
  const shippingEl = document.getElementById('cartShipping');
  const totalEl = document.getElementById('cartTotal');
  const countEl = document.getElementById('cartItemCount');
  const couponWrap = document.getElementById('couponApplied');

  if (subtotalEl) subtotalEl.textContent = fmt(totals.subtotal);
  if (shippingEl) shippingEl.textContent = totals.shipping === 0 ? 'Gratis' : fmt(totals.shipping);
  if (totalEl) totalEl.textContent = fmt(totals.total);
  if (countEl) countEl.textContent = totals.itemCount + (totals.itemCount === 1 ? ' producto' : ' productos');
  if (discountEl) {
    if (totals.discount > 0) {
      discountEl.textContent = '-' + fmt(totals.discount);
      discountEl.style.display = '';
    } else discountEl.style.display = 'none';
  }
  if (couponWrap) couponWrap.style.display = totals.couponName ? '' : 'none';
  if (couponWrap && totals.couponName) {
    couponWrap.innerHTML = '<span>Cupón <b>' + totals.couponName + '</b> aplicado</span>' +
      '<button onclick="removeCoupon()"><i class="bi bi-x-lg"></i></button>';
  }
}

function applyCoupon() {
  const input = document.getElementById('couponInput');
  const code = input.value.trim().toUpperCase();
  if (!code) return notify('warning', 'bi-exclamation-triangle', 'Escribe un código de cupón');
  if (!Store.COUPONS[code]) return notify('danger', 'bi-x-circle', 'Código de cupón no válido');
  activeCoupon = code;
  updateSummary();
  notify('success', 'bi-check-circle', 'Cupón ' + code + ' aplicado (' + Store.COUPONS[code] + '% de descuento)');
  input.value = '';
}

function removeCoupon() {
  activeCoupon = null;
  updateSummary();
  notify('warning', 'bi-sd-card', 'Cupón eliminado');
}

function clearCart() {
  Store.saveCart([]);
  renderCart();
  notify('warning', 'bi-bag-x', 'Carrito vaciado');
}

/* ---------- Inicialización por página ---------- */

document.addEventListener('DOMContentLoaded', () => {
  if (!window.APP_DATA) return;
  loadCommon();
  const page = document.body.getAttribute('data-page') || 'dashboard';

  if (page === 'productos') {
    const q = getQueryParam('q');
    if (q) {
      const s = document.getElementById('productSearch');
      if (s) { s.value = q; }
    }
    setupProductFilters();
  }

  if (page === 'productos.crear' || page === 'productos.editar') {
    initStandaloneProductForm();
  }

  if (page === 'carrito') {
    renderCart();
    const couponBtn = document.getElementById('couponBtn');
    if (couponBtn) couponBtn.addEventListener('click', applyCoupon);
    const checkout = document.getElementById('checkoutBtn');
    if (checkout) checkout.addEventListener('click', () => {
      if (!Store.getCart().length) return notify('warning', 'bi-exclamation-triangle', 'Tu carrito está vacío');
      notify('success', 'bi-check-circle', 'Pedido enviado. Esperando pago del cliente', 4200);
      Store.saveCart([]);
      setTimeout(() => { window.location.href = '/pedidos'; }, 1400);
    });
  }
});