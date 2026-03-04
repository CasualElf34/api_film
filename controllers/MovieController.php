<?php

require_once __DIR__ . '/../services/TMDBService.php';

class MovieController {

    /**
     * GET /movies?type=popular
     * Retourne une liste de films selon le type
     */
    public static function list(string $type): void {
        $movies = TMDBService::getMovies($type);

        if (isset($movies['error'])) {
            http_response_code(500);
        } else {
            http_response_code(200);
        }

        echo json_encode($movies, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * GET /movies/search?q=batman
     * Recherche un film par nom
     */
    public static function search(string $query): void {
        if (empty($query)) {
            http_response_code(400);
            echo json_encode(['error' => 'Paramètre "q" manquant.']);
            return;
        }

        $results = TMDBService::searchMovies($query);
        echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
