<?php
/**
 * Controlador de Vistas y Helpers para Proyecto PHP Puro (Sin Laravel)
 */

class ViewController
{
    /**
     * Obtiene la URL base dinámica del proyecto (útil tanto en localhost como en producción)
     */
    public static function getBaseUrl(): string
    {
        static $baseUrl = null;
        if ($baseUrl === null) {
            $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
            $baseUrl = ($scriptDir === '/' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');
        }
        return $baseUrl;
    }

    /**
     * Genera la ruta para un recurso estático (CSS, JS, imágenes)
     */
    public static function asset(string $path): string
    {
        return self::getBaseUrl() . '/' . ltrim($path, '/');
    }

    /**
     * Genera la URL para una ruta o página interna
     */
    public static function url(string $path = ''): string
    {
        return self::getBaseUrl() . '/' . ltrim($path, '/');
    }

    /**
     * Renderiza una vista dentro del layout principal
     *
     * @param string $viewName Nombre del archivo en views/ (sin extensión .php)
     * @param array $data Variables que estarán disponibles en la vista
     * @param string|null $layout Nombre del layout en views/layouts/ (o null para sin layout)
     */
    public static function render(string $viewName, array $data = [], ?string $layout = 'main'): void
    {
        // Extrae las variables para que estén disponibles en la vista
        extract($data);

        // Sanear el nombre de la vista
        $viewName = trim($viewName, '/');
        $viewName = preg_replace('/\.php$/', '', $viewName);

        $viewFile = __DIR__ . '/views/' . $viewName . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(404);
            $viewFile = __DIR__ . '/views/404.php';
        }

        // Captura el contenido de la vista
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Si se especificó un layout, lo renderiza pasando $content
        if ($layout) {
            $layoutFile = __DIR__ . '/views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
        }

        // Si no hay layout, imprime el contenido directamente
        echo $content;
    }
}

// Helpers globales para fácil uso en plantillas y vistas
if (!function_exists('asset')) {
    function asset(string $path): string {
        return ViewController::asset($path);
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        return ViewController::url($path);
    }
}

if (!function_exists('view')) {
    function view(string $viewName, array $data = [], ?string $layout = 'main'): void {
        ViewController::render($viewName, $data, $layout);
    }
}
