<?php

// ============================
// CONFIGURATION & IMPORTS
// ============================
require_once 'config/config.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/FavoriteController.php';
require_once 'html/index.html';

// On dit au client qu'on répond toujours en JSON
header("Content-Type: application/json");

// Autorise les requêtes depuis n'importe quel domaine (utile pour tester)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ============================
// ROUTER
// ============================

// Récupère le chemin de l'URL (ex: /movies, /favorites)
$path   = strtok($_SERVER['REQUEST_URI'], '?'); // Enlève les paramètres ?type=xxx
$method = $_SERVER['REQUEST_METHOD'];           // GET, POST, DELETE...

// ── Route : GET /movies ──────────────────────────────────────────
// Exemple : GET /movies?type=popular
if ($path === '/movies' && $method === 'GET') {
    $type = $_GET['type'] ?? 'popular';
    MovieController::list($type);

// ── Route : GET /movies/search ───────────────────────────────────
// Exemple : GET /movies/search?q=batman
} elseif ($path === '/movies/search' && $method === 'GET') {
    $query = $_GET['q'] ?? '';
    MovieController::search($query);

// ── Route : GET /favorites ───────────────────────────────────────
} elseif ($path === '/favorites' && $method === 'GET') {
    FavoriteController::index();

// ── Route : POST /favorites ──────────────────────────────────────
// Corps : { "id": 123, "title": "Batman", "poster_path": "/xyz.jpg" }
} elseif ($path === '/favorites' && $method === 'POST') {
    FavoriteController::store();

// ── Route : DELETE /favorites ─────────────────────────────────────
// Exemple : DELETE /favorites?id=123
} elseif ($path === '/favorites' && $method === 'DELETE') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    FavoriteController::delete($id);

// ── Route inconnue ────────────────────────────────────────────────
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
