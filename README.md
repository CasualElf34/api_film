# 🎬 API Films – PHP + TMDB

API RESTful en PHP pour récupérer et gérer des films via TMDB.

---

## ⚙️ Installation

### 1. Obtenir une clé API TMDB
1. Va sur [themoviedb.org](https://www.themoviedb.org/)
2. Crée un compte → Paramètres → API → Demander une clé (gratuit)
3. Copie ta clé API

### 2. Configurer le projet
Ouvre `config/config.php` et remplace :
```php
define('TMDB_API_KEY', 'VOTRE_CLE_API');
```
par ta vraie clé.

### 3. Lancer le serveur
Dans le dossier `api-films/`, exécute :
```bash
php -S localhost:8000
```

---

## 📡 Routes disponibles

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/movies?type=popular` | Films populaires |
| GET | `/movies?type=top_rated` | Films les mieux notés |
| GET | `/movies?type=upcoming` | Films à venir |
| GET | `/movies?type=now_playing` | Films en ce moment |
| GET | `/movies/search?q=batman` | Rechercher un film |
| GET | `/favorites` | Voir tous les favoris |
| POST | `/favorites` | Ajouter un favori |
| DELETE | `/favorites?id=123` | Supprimer un favori |

---

## 🧪 Exemples de requêtes (Postman / curl)

### Films populaires
```
GET http://localhost:8000/movies?type=popular
```

### Rechercher un film
```
GET http://localhost:8000/movies/search?q=inception
```

### Ajouter un favori
```
POST http://localhost:8000/favorites
Content-Type: application/json

{
  "id": 27205,
  "title": "Inception",
  "poster_path": "/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg"
}
```

### Supprimer un favori
```
DELETE http://localhost:8000/favorites?id=27205
```

---

## 📁 Structure du projet

```
api-films/
├── index.php               ← Point d'entrée + routeur
├── config/
│   └── config.php          ← Clé API et constantes
├── services/
│   └── TMDBService.php     ← Appels vers l'API TMDB
├── controllers/
│   ├── MovieController.php     ← Logique des films
│   └── FavoriteController.php  ← Logique des favoris
└── data/
    └── favorites.json      ← Favoris stockés (créé automatiquement)
```
