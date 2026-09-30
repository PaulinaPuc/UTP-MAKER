<?php
/**
 * Front Controller & Router Principal - Proyecto PHP Puro (Sin Laravel)
 */

require_once __DIR__ . '/ViewController.php';

// Obtener la ruta solicitada
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$basePath = ViewController::getBaseUrl();

// Si el proyecto se encuentra en una subcarpeta (ej. /UTP-MAKER), removerla de la ruta
if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// Limpiar la ruta solicitada
$route = trim($requestUri, '/');

// Quitar extensiones .php o .html si el usuario las escribe en la URL
$route = preg_replace('/\.(php|html)$/', '', $route);

// Si la ruta está vacía o es 'index', cargar la página de inicio
if ($route === '' || $route === 'index') {
    $route = 'index';
}

// Renderizar la vista con el layout principal
view($route);
