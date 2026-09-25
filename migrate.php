<?php
$viewsDir = __DIR__ . '/resources/views';
$layoutsDir = $viewsDir . '/layouts';

if (!is_dir($layoutsDir)) {
    mkdir($layoutsDir, 0755, true);
}

// 1. Get layout parts from index.blade.php
$indexContent = file_get_contents($viewsDir . '/index.blade.php');

$headerEnd = strpos($indexContent, '</header>') + 9;
$footerStart = strpos($indexContent, '<!--------------- footer-section--------------->');

if ($headerEnd === 8 || $footerStart === false) {
    die("Could not find boundaries in index.blade.php\n");
}

$topLayout = substr($indexContent, 0, $headerEnd);
$bottomLayout = substr($indexContent, $footerStart);

// Clean up links in layout
$topLayout = preg_replace('/href="index\.html"/', 'href="/"', $topLayout);
$topLayout = preg_replace('/href="([^"]+)\.html"/', 'href="/$1"', $topLayout);
$bottomLayout = preg_replace('/href="index\.html"/', 'href="/"', $bottomLayout);
$bottomLayout = preg_replace('/href="([^"]+)\.html"/', 'href="/$1"', $bottomLayout);

// Save layout
$layoutContent = $topLayout . "\n\n@yield('content')\n\n" . $bottomLayout;
file_put_contents($layoutsDir . '/main.blade.php', $layoutContent);
echo "Created layouts/main.blade.php\n";

// 2. Process all html files and index.blade.php
$files = glob($viewsDir . '/*.html');
$files[] = $viewsDir . '/index.blade.php';

$routes = [];

foreach ($files as $file) {
    $filename = basename($file);
    if ($filename === 'main.blade.php') continue;

    $name = str_replace(['.html', '.blade.php'], '', $filename);
    $content = file_get_contents($file);

    $hEnd = strpos($content, '</header>');
    $fStart = strpos($content, '<!--------------- footer-section--------------->');

    if ($hEnd !== false && $fStart !== false) {
        $hEnd += 9; // length of </header>
        // Check for 'header-section-end' comment
        $commentEnd = strpos($content, '--------------->', $hEnd);
        if ($commentEnd !== false && $commentEnd < $hEnd + 100) {
            $hEnd = $commentEnd + 16;
        }

        $innerContent = substr($content, $hEnd, $fStart - $hEnd);

        // Clean up links in inner content
        $innerContent = preg_replace('/href="index\.html"/', 'href="/"', $innerContent);
        $innerContent = preg_replace('/href="([^"]+)\.html"/', 'href="/$1"', $innerContent);

        $newFileContent = "@extends('layouts.main')\n@section('content')\n" . trim($innerContent) . "\n@endsection\n";

        file_put_contents($viewsDir . '/' . $name . '.blade.php', $newFileContent);
        echo "Processed $name.blade.php\n";

        if ($filename !== $name . '.blade.php') {
            unlink($file); // Delete old .html file
        }

        if ($name !== 'index') {
            $routes[] = "Route::get('/$name', fn () => view('$name'))->name('$name');";
        }
    } else {
        echo "Skipped $filename (could not find boundaries)\n";
    }
}

// 3. Append routes to web.php
$routesContent = "\n// Generated Routes for Template\n" . implode("\n", $routes) . "\n";
file_put_contents(__DIR__ . '/routes/web.php', $routesContent, FILE_APPEND);
echo "Appended routes to routes/web.php\n";

