<?php

require_once __DIR__ . '/controllers/auth.php';
require_once __DIR__ . '/controllers/todo.php';

/**
 * Route table: [method][path] = handler_function_name
 */
$routes = [
    'GET' => [
        '/'           => 'todo_index',
        '/login'      => 'auth_show_login',
        '/register'   => 'auth_show_register',
        '/todos'      => 'todo_index',
        '/todos/create' => 'todo_show_create',
        '/todos/edit'   => 'todo_show_edit', // expects ?id=
    ],
    'POST' => [
        '/login'        => 'auth_login',
        '/register'     => 'auth_register',
        '/logout'       => 'auth_logout',
        '/todos/store'  => 'todo_store',
        '/todos/update' => 'todo_update_handler',
        '/todos/delete' => 'todo_delete_handler',
    ],
];

function dispatch()
{
    global $routes;

    $method = $_SERVER['REQUEST_METHOD'];

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $path = '/' . trim(str_replace($scriptName, '', $uri), '/');
    if ($path === '//') $path = '/';

    if (isset($routes[$method][$path])) {
        $handler = $routes[$method][$path];
        if (function_exists($handler)) {
            return $handler();
        }
    }

    http_response_code(404);
    echo "<h1>404 Not Found</h1><p>No route for $method $path</p>";
}
