/* ============================================================
   DATOS DE EJEMPLO · Preparados para conectar con backend/BD
   ============================================================ */

window.APP_DATA = {
  store: { name: 'Lavandia', tagline: 'Tienda Premium' },
  user: { name: 'Valentina Ríos', role: 'Administradora', initials: 'VR', email: 'valentina@lavandia.shop' },

  products: [
    { id: 1, name: 'Audifonos Inalambricos Aura', category: 'Audio', price: 1499, oldPrice: 1899, stock: 34, rating: 4.8, img: 'p1.svg', desc: 'Audifonos over-ear con cancelacion activa de ruido, 40h de bateria y sonido Hi-Res. Incluyen estuche de carga y Bluetooth 5.3.' },
    { id: 2, name: 'Smartwatch Pulse Fit', category: 'Tecnologia', price: 2199, oldPrice: 2599, stock: 18, rating: 4.6, img: 'p2.svg', desc: 'Reloj inteligente con monitor de ritmo cardiaco, GPS, resistencia al agua 5ATM y pantalla AMOLED siempre activa.' },
    { id: 3, name: 'Camiseta Essential Soft', category: 'Ropa', price: 349, oldPrice: 449, stock: 120, rating: 4.3, img: 'p3.svg', desc: 'Camiseta de algodon organico de corte regular. Suave al tacto, transpirable y con costuras reforzadas.' },
    { id: 4, name: 'Lampara Ambiental Nebula', category: 'Hogar', price: 899, oldPrice: 1099, stock: 8, rating: 4.7, img: 'p4.svg', desc: 'Lampara de escritorio con luz RGB regulable, 16 millones de colores y control por app. Base de aluminio cepillado.' },
    { id: 5, name: 'Zapatillas Urban Flex', category: 'Calzado', price: 1290, oldPrice: 1590, stock: 27, rating: 4.5, img: 'p5.svg', desc: 'Zapatillas deportivas ultraligeras con suela de espuma reactiva y exterior de malla transpirable.' },
    { id: 6, name: 'Teclado Mecanico Klip', category: 'Tecnologia', price: 1699, oldPrice: 2000, stock: 5, rating: 4.9, img: 'p6.svg', desc: 'Teclado mecanico compacto con switches intercambiables, retroiluminacion RGB y carcasa de aluminio.' },
    { id: 7, name: 'Serum Facial Vitamina C', category: 'Belleza', price: 549, oldPrice: 650, stock: 60, rating: 4.4, img: 'p7.svg', desc: 'Serum iluminador con vitamina C estable y acido hialuronico. Formula vegana y libre de parabenos.' },
    { id: 8, name: 'Blazer Line Tempo', category: 'Ropa', price: 2350, oldPrice: 2800, stock: 14, rating: 4.7, img: 'p8.svg', desc: 'Blazer sastre con corte slim, tela de mezcla de lana y forro de saten. Elegancia para cualquier ocasion.' },
    { id: 9, name: 'Cafetera Ritual Barista', category: 'Hogar', price: 3499, oldPrice: 4200, stock: 3, rating: 4.8, img: 'p9.svg', desc: 'Cafetera de goteo profesional con control de temperatura, temporizador y jarra termica de vidrio.' },
    { id: 10, name: 'Mochila Viajera Nord', category: 'Accesorios', price: 990, oldPrice: 1200, stock: 0, rating: 4.2, img: 'p10.svg', desc: 'Mochila impermeable de 25L con compartimento para laptop de 15", puerto USB y correas acolchadas.' }
  ],

  customers: [
    { id: 1, name: 'Maria Fernandez', email: 'maria@correo.com', phone: '+52 55 1234 5601', orders: 12, total: 18450, last: '2026-09-14', avatar: 'av-a' },
    { id: 2, name: 'Luis Hernandez', email: 'luis.h@correo.com', phone: '+52 55 1234 5602', orders: 8, total: 9650, last: '2026-09-13', avatar: 'av-b' },
    { id: 3, name: 'Ana Gutierrez', email: 'ana.g@correo.com', phone: '+52 55 1234 5603', orders: 5, total: 6200, last: '2026-09-12', avatar: 'av-c' },
    { id: 4, name: 'Carlos Mendoza', email: 'carlos.m@correo.com', phone: '+52 55 1234 5604', orders: 15, total: 23120, last: '2026-09-11', avatar: 'av-d' },
    { id: 5, name: 'Sofia Ramirez', email: 'sofia.r@correo.com', phone: '+52 55 1234 5605', orders: 3, total: 3850, last: '2026-09-10', avatar: 'av-e' },
    { id: 6, name: 'Diego Torres', email: 'diego.t@correo.com', phone: '+52 55 1234 5606', orders: 9, total: 11000, last: '2026-09-09', avatar: 'av-f' },
    { id: 7, name: 'Lucia Salazar', email: 'lucia.s@correo.com', phone: '+52 55 1234 5607', orders: 6, total: 7890, last: '2026-09-08', avatar: 'av-g' },
    { id: 8, name: 'Jorge Alvarado', email: 'jorge.a@correo.com', phone: '+52 55 1234 5608', orders: 11, total: 14230, last: '2026-09-07', avatar: 'av-h' }
  ],

  orders: [
    { id: 'ORD-2841', customer: 'Maria Fernandez', date: '2026-09-14 09:24', items: 3, total: 4297, status: 'entregado', method: 'Tarjeta' },
    { id: 'ORD-2840', customer: 'Luis Hernandez', date: '2026-09-14 08:05', items: 1, total: 1499, status: 'enviado', method: 'PayPal' },
    { id: 'ORD-2839', customer: 'Ana Gutierrez', date: '2026-09-13 21:41', items: 5, total: 8126, status: 'procesando', method: 'Tarjeta' },
    { id: 'ORD-2838', customer: 'Carlos Mendoza', date: '2026-09-13 18:12', items: 2, total: 2380, status: 'pendiente', method: 'Transferencia' },
    { id: 'ORD-2837', customer: 'Sofia Ramirez', date: '2026-09-13 15:37', items: 1, total: 2350, status: 'cancelado', method: 'Tarjeta' },
    { id: 'ORD-2836', customer: 'Diego Torres', date: '2026-09-12 12:03', items: 4, total: 6188, status: 'enviado', method: 'PayPal' },
    { id: 'ORD-2835', customer: 'Lucia Salazar', date: '2026-09-12 10:50', items: 2, total: 2448, status: 'cancelado', method: 'Tarjeta' },
    { id: 'ORD-2834', customer: 'Jorge Alvarado', date: '2026-09-11 16:29', items: 6, total: 9450, status: 'procesando', method: 'Transferencia' }
  ],

  sales: [
    { id: 'VNT-9001', date: '2026-09-14', customer: 'Maria Fernandez', total: 4297, method: 'Tarjeta', status: 'completada' },
    { id: 'VNT-9002', date: '2026-09-13', customer: 'Carlos Mendoza', total: 8126, method: 'PayPal', status: 'completada' },
    { id: 'VNT-9003', date: '2026-09-12', customer: 'Diego Torres', total: 6188, method: 'Tarjeta', status: 'pendiente' },
    { id: 'VNT-9004', date: '2026-09-11', customer: 'Sofia Ramirez', total: 2350, method: 'Transferencia', status: 'completada' },
    { id: 'VNT-9005', date: '2026-09-10', customer: 'Luis Hernandez', total: 1499, method: 'PayPal', status: 'completada' },
    { id: 'VNT-9006', date: '2026-09-09', customer: 'Ana Gutierrez', total: 2448, method: 'Tarjeta', status: 'cancelada' },
    { id: 'VNT-9007', date: '2026-09-08', customer: 'Jorge Alvarado', total: 9450, method: 'Tarjeta', status: 'completada' }
  ],

  inventory: [
    { id: 1, product: 'Audifonos Inalambricos Aura', sku: 'SKU-AUR-01', stock: 34, min: 10, max: 80, warehouse: 'Bodega Central' },
    { id: 2, product: 'Smartwatch Pulse Fit', sku: 'SKU-PLS-02', stock: 18, min: 10, max: 60, warehouse: 'Bodega Norte' },
    { id: 3, product: 'Camiseta Essential Soft', sku: 'SKU-CAM-03', stock: 120, min: 30, max: 200, warehouse: 'Bodega Central' },
    { id: 4, product: 'Lampara Ambiental Nebula', sku: 'SKU-LAM-04', stock: 8, min: 10, max: 40, warehouse: 'Bodega Sur' },
    { id: 5, product: 'Zapatillas Urban Flex', sku: 'SKU-ZAP-05', stock: 27, min: 15, max: 70, warehouse: 'Bodega Norte' },
    { id: 6, product: 'Teclado Mecanico Klip', sku: 'SKU-TEC-06', stock: 5, min: 10, max: 40, warehouse: 'Bodega Central' },
    { id: 7, product: 'Serum Facial Vitamina C', sku: 'SKU-SER-07', stock: 4, min: 12, max: 50, warehouse: 'Bodega Sur' },
    { id: 8, product: 'Cafetera Ritual Barista', sku: 'SKU-CAF-09', stock: 3, min: 6, max: 30, warehouse: 'Bodega Central' },
    { id: 9, product: 'Mochila Viajera Nord', sku: 'SKU-MOC-10', stock: 0, min: 10, max: 40, warehouse: 'Bodega Norte' }
  ],

  users: [
    { id: 1, name: 'Valentina Ríos', email: 'valentina@lavandia.shop', role: 'Administradora', status: 'Activo', last: '2026-09-15 10:24', avatar: 'av-a' },
    { id: 2, name: 'Carlos Mendoza', email: 'carlos.m@correo.com', role: 'Vendedor', status: 'Activo', last: '2026-09-14 16:02', avatar: 'av-d' },
    { id: 3, name: 'Lucia Salazar', email: 'lucia.s@correo.com', role: 'Inventario', status: 'Activo', last: '2026-09-14 11:37', avatar: 'av-g' },
    { id: 4, name: 'Diego Torres', email: 'diego.t@correo.com', role: 'Vendedor', status: 'Inactivo', last: '2026-09-10 09:12', avatar: 'av-f' },
    { id: 5, name: 'Sofia Ramirez', email: 'sofia.r@correo.com', role: 'Contabilidad', status: 'Activo', last: '2026-09-12 14:45', avatar: 'av-e' }
  ],

  categories: ['Audio', 'Tecnologia', 'Ropa', 'Hogar', 'Calzado', 'Belleza', 'Accesorios'],

  notifications: [
    { type: 'success', icon: 'bi-bag-check', text: 'Nuevo pedido ORD-2841 por $4,297 MXN', time: 'hace 5 min' },
    { type: 'primary', icon: 'bi-box-seam', text: 'Stock bajo en Cafetera Ritual Barista', time: 'hace 22 min' },
    { type: 'warning', icon: 'bi-exclamation-triangle', text: 'Stock bajo en Serum Facial Vitamina C', time: 'hace 1 hora' },
    { type: 'danger', icon: 'bi-x-circle', text: 'Pedido ORD-2835 cancelado por el cliente', time: 'hace 2 horas' },
    { type: 'success', icon: 'bi-star', text: 'Nueva reseña 5 estrellas en Teclado Klip', time: 'hace 3 horas' }
  ],

  salesChart: {
    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep'],
    ventas: [22, 28, 25, 34, 30, 41, 38, 47, 52],
    pedidos: [12, 15, 14, 18, 17, 22, 20, 26, 30]
  },

  categoryChart: {
    labels: ['Tecnologia', 'Ropa', 'Hogar', 'Audio', 'Belleza', 'Otros'],
    values: [28, 24, 18, 14, 10, 6]
  }
};