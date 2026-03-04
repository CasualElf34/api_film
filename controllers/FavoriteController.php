<?php

class FavoriteController {

    private static string $file = __DIR__ . '/../data/favorites.json';

    private static function load(): array {
        if (!file_exists(self::$file)) {
            return [];
        }
        $content = file_get_contents(self::$file);
        return json_decode($content, true) ?? [];
    }

    private static function save(array $favorites): void {
        file_put_contents(self::$file, json_encode($favorites, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function index(): void {
        $favorites = self::load();
        http_response_code(200);
        echo json_encode($favorites, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function store(): void {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if (!$data || !isset($data['id'], $data['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Corps invalide. "id" et "title" sont requis.']);
            return;
        }

        $favorites = self::load();

        foreach ($favorites as $fav) {
            if ($fav['id'] === $data['id']) {
                http_response_code(409);
                echo json_encode(['error' => 'Ce film est déjà dans les favoris.']);
                return;
            }
        }

        $favorites[] = [
            'id'          => $data['id'],
            'title'       => $data['title'],
            'poster_path' => $data['poster_path'] ?? null,
            'added_at'    => date('Y-m-d H:i:s'),
        ];

        self::save($favorites);

        http_response_code(201);
        echo json_encode(['message' => 'Film ajouté aux favoris !', 'film' => end($favorites)], JSON_UNESCAPED_UNICODE);
    }

    public static function delete(int $id): void {
        $favorites = self::load();
        $newList = array_filter($favorites, fn($f) => $f['id'] !== $id);

        if (count($newList) === count($favorites)) {
            http_response_code(404);
            echo json_encode(['error' => 'Film non trouvé dans les favoris.']);
            return;
        }

        self::save(array_values($newList));
        http_response_code(200);
        echo json_encode(['message' => 'Film supprimé des favoris.']);
    }
}
