@extends('layouts.main')

@section('page', 'producto')
@section('nav', 'productos')
@section('title', 'Detalle de producto · Lavandia')

@section('content')

  <x-page-header :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Productos', 'url' => route('productos.index')], ['label' => 'Detalle']]"
    title="Detalle de producto">
  </x-page-header>

  <div id="productDetail">
    <div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>
  </div>

  <div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h2 class="h5 mb-0 fw-bold">También te puede interesar</h2>
        <small class="text-muted-soft">Productos de la misma categoría</small>
      </div>
    </div>
    <div class="p-grid" id="relatedGrid"></div>
  </div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const id = parseInt('{{ $producto }}') || 1;
    const p = window.APP_DATA.products.find(x => x.id === id);
    const box = document.getElementById('productDetail');
    if (!p) {
      box.innerHTML = '<div class="card empty-state"><i class="bi bi-box"></i><h5>Producto no encontrado</h5>' +
        '<a href="/productos" class="btn btn-primary mt-3">Volver al catálogo</a></div>';
      return;
    }
    document.querySelector('.page-head h1').textContent = p.name;

    const imgs = [p.img, p.img, p.img].map((im, i) =>
      '<button class="detail-thumb ' + (i === 0 ? 'active' : '') + '" data-thumb="' + i + '">' +
      '<img src="' + imgPath(im) + '" alt="Vista ' + (i + 1) + '"></button>').join('');

    box.innerHTML =
      '<div class="row g-4 g-lg-5">' +
      '<div class="col-12 col-lg-6">' +
      '<div class="card overflow-hidden mb-3">' +
      '<img src="' + imgPath(p.img) + '" id="mainImage" alt="' + p.name + '" class="w-100" style="aspect-ratio:1/1;object-fit:cover">' +
      '</div>' +
      '<div class="d-flex gap-2 flex-wrap" id="thumbs">' + imgs + '</div>' +
      '</div>' +
      '<div class="col-12 col-lg-6">' +
      '<div class="p-cat mb-2">' + p.category + '</div>' +
      '<h1 class="fw-bold mb-2" style="font-size:26px;letter-spacing:-.4px">' + p.name + '</h1>' +
      '<div class="rating-wrap mb-3">' + stars(p.rating) + ' <span>' + p.rating.toFixed(1) + ' · 124 reseñas</span>' +
      '<span class="ms-2 badge-soft badge-g"><i class="bi bi-patch-check"></i> Verificado</span></div>' +
      '<div class="d-flex align-items-end gap-3 mb-3">' +
      '<h2 class="fw-bold mb-0" style="font-size:32px;color:var(--primary)">' + fmt(p.price) + '</h2>' +
      (p.oldPrice ? '<span class="text-muted-soft text-decoration-line-through mb-1 fs-5">' + fmt(p.oldPrice) + '</span>' +
        '<span class="badge-soft badge-p mb-1">Ahorra ' + fmt(p.oldPrice - p.price) + '</span>' : '') +
      '</div>' +
      '<p class="text-muted-soft mb-4" style="line-height:1.7">' + p.desc + '</p>' +
      '<div class="row g-3 mb-4">' +
      '<div class="col-6 col-md-3"><div class="badge-soft badge-o w-100 py-2 text-center"><i class="bi bi-truck me-1"></i>Envío 24h</div></div>' +
      '<div class="col-6 col-md-3"><div class="badge-soft badge-g w-100 py-2 text-center"><i class="bi bi-shield-check me-1"></i>Garantía</div></div>' +
      '<div class="col-6 col-md-3"><div class="badge-soft badge-i w-100 py-2 text-center"><i class="bi bi-arrow-repeat me-1"></i>Devoluciones</div></div>' +
      '<div class="col-6 col-md-3"><div class="badge-soft badge-w w-100 py-2 text-center"><i class="bi bi-star me-1"></i>Top ventas</div></div>' +
      '</div>' +
      '<div class="d-flex flex-wrap align-items-center gap-3 mb-4">' +
      '<div class="d-flex align-items-center border rounded-4 p-1" style="border-color:var(--line)!important">' +
      '<button class="qty-btn" onclick="setDetailQty(-1)"><i class="bi bi-dash"></i></button>' +
      '<span class="fw-bold px-3" id="detailQty" style="min-width:46px;text-align:center">1</span>' +
      '<button class="qty-btn" onclick="setDetailQty(1)"><i class="bi bi-plus"></i></button>' +
      '</div>' +
      '<button class="btn btn-primary btn-lg flex-grow-1" style="min-width:200px" onclick="addToCartNow()">' +
      '<i class="bi bi-cart-plus me-2"></i>Agregar al carrito</button>' +
      '</div>' +
      '<button class="btn btn-success-grad btn-lg w-100" onclick="buyNow()">' +
      '<i class="bi bi-lightning-charge me-2"></i>Comprar ahora</button>' +
      '<div class="d-flex justify-content-between mt-4 pt-3 border-top small text-muted-soft" style="border-color:var(--line)!important">' +
      '<span><i class="bi bi-box-seam me-2"></i>SKU: SKU-PRD-' + String(p.id).padStart(3, '0') + '</span>' +
      '<span><i class="bi bi-shield-lock me-2"></i>Compra protegida</span>' +
      '<span><i class="bi bi-truck me-2"></i>' + (p.stock > 0 ? 'Disponible' : 'Agotado') + '</span>' +
      '</div>' +
      '</div>' +
      '</div>';

    const thumbsBox = document.getElementById('thumbs');
    if (thumbsBox) {
      thumbsBox.querySelectorAll('.detail-thumb').forEach(b => {
        b.addEventListener('click', () => {
          document.getElementById('mainImage').src = b.querySelector('img').src;
          thumbsBox.querySelectorAll('.detail-thumb').forEach(x => x.classList.remove('active'));
          b.classList.add('active');
        });
      });
    }

    const relBox = document.getElementById('relatedGrid');
    relBox.innerHTML = window.APP_DATA.products.slice(0, 4).map(p2 =>
      '<div class="p-card">' +
      '<div class="p-img-wrap"><img src="' + imgPath(p2.img) + '" class="p-img" alt="' + p2.name + '">' +
      '<div class="p-actions"><button onclick="location.href=\'/productos/' + p2.id + '\'"><i class="bi bi-eye"></i></button>' +
      '<button onclick="Store.add(' + p2.id + ')"><i class="bi bi-cart-plus"></i></button></div></div>' +
      '<div class="p-body"><div class="p-cat">' + p2.category + '</div>' +
      '<a class="p-name d-block mb-2" href="/productos/' + p2.id + '">' + p2.name + '</a>' +
      '<div class="p-foot"><div class="p-price fs-5">' + fmt(p2.price) + '</div>' +
      '<button class="btn btn-soft btn-sm" onclick="Store.add(' + p2.id + ')"><i class="bi bi-cart-plus"></i></button></div></div></div>'
    ).join('');

    window.CURRENT_PRODUCT = p;
    window.DETAIL_QTY = 1;
  });

  function setDetailQty(delta) {
    const el = document.getElementById('detailQty');
    window.DETAIL_QTY = Math.max(1, Math.min((window.DETAIL_QTY || 1) + delta, (window.CURRENT_PRODUCT.stock || 99)));
    el.textContent = window.DETAIL_QTY;
  }

  function addToCartNow() {
    if (!window.CURRENT_PRODUCT) return;
    Store.add(window.CURRENT_PRODUCT.id, window.DETAIL_QTY);
  }

  function buyNow() {
    if (!window.CURRENT_PRODUCT) return;
    Store.add(window.CURRENT_PRODUCT.id, window.DETAIL_QTY);
    window.location.href = '/ventas/crear';
  }
</script>
@endpush