<?php

class TMDBService {

    public static function getMovies(string $type): array {
        $validTypes = ['popular', 'top_rated', 'upcoming', 'now_playing'];

        if (!in_array($type, $validTypes)) {
            return ['error' => "Type invalide. Types acceptés : " . implode(', ', $validTypes)];
        }

        $url = TMDB_BASE_URL . "/movie/{$type}?api_key=" . TMDB_API_KEY . "&language=fr-FR";

        try {
            $response = file_get_contents($url);

            if ($response === false) {
                return ['error' => 'Impossible de contacter TMDB. Vérifie ta clé API.'];
            }

            return json_decode($response, true);

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function searchMovies(string $query): array {
        $url = TMDB_BASE_URL . "/search/movie?api_key=" . TMDB_API_KEY . "&language=fr-FR&query=" . urlencode($query);

        try {
            $response = file_get_contents($url);

            if ($response === false) {
                return ['error' => 'Impossible de contacter TMDB.'];
            }

            return json_decode($response, true);

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
