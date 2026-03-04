<?php

require_once 'config/config.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/FavoriteController.php';

$path   = strtok($_SERVER['REQUEST_URI'], '?');
$method = $_SERVER['REQUEST_METHOD'];

if (($path === '/' || $path === '') && $method === 'GET') {
    readfile(__DIR__ . '/html/index.html');
    exit;
}

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($path === '/movies' && $method === 'GET') {
    $type = $_GET['type'] ?? 'popular';
    MovieController::list($type);

} elseif ($path === '/movies/search' && $method === 'GET') {
    $query = $_GET['q'] ?? '';
    MovieController::search($query);

} elseif ($path === '/favorites' && $method === 'GET') {
    FavoriteController::index();

} elseif ($path === '/favorites' && $method === 'POST') {
    FavoriteController::store();

} elseif ($path === '/favorites' && $method === 'DELETE') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    FavoriteController::delete($id);

} else {
    http_response_code(404);
    echo json_encode([
        'error'  => 'Route inconnue',
        'routes' => [
            'GET /movies?type=popular'     => 'Films populaires (popular, top_rated, upcoming, now_playing)',
            'GET /movies/search?q=batman'  => 'Rechercher un film',
            'GET /favorites'               => 'Voir les favoris',
            'POST /favorites'              => 'Ajouter un favori',
            'DELETE /favorites?id=123'     => 'Supprimer un favori',
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
