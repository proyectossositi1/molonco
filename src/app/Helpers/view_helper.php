<?php

if (!function_exists('renderPage')) {
    function renderPage(array $params = [])
    {
        $view   = $params['view']   ?? 'errors/html/error_404'; // Vista a cargar
        $layout = $params['layout'] ?? 'dashboard'; // Layout por defecto
        $data   = $params['data']   ?? []; // Datos para la vista

        // 🔍 Verificar si la vista existe antes de cargarla
        if (!view_exists($view)) {
            throw new \CodeIgniter\View\Exceptions\ViewException("La vista {$view} no existe.");
        }

        $data['body'] = view($view, $data);
        return view("layouts/{$layout}", $data);
    }
}

// ✅ Función para verificar si la vista existe
if (!function_exists('view_exists')) {
    function view_exists($view)
    {
        return file_exists(APPPATH . "Views/" . str_replace('.', '/', $view) . ".php");
    }
}