# 🎬 CinéAPI

Application web et API RESTful en PHP permettant de parcourir, rechercher et gérer des films via l'API [TMDB](https://www.themoviedb.org/). Inclut une interface web intégrée avec recherche en temps réel et gestion des favoris.

---

## Fonctionnalités

- Parcourir les films populaires, les mieux notés, à venir et en salle
- Recherche en temps réel avec debounce
- Ajout / suppression de favoris (stockés en JSON côté serveur + localStorage)
- Interface web responsive intégrée (servie sur `/`)
- API JSON pour intégration externe

---

## Installation

### 1. Clé API TMDB

1. Crée un compte sur [themoviedb.org](https://www.themoviedb.org/)
2. Va dans **Paramètres → API → Demander une clé** (gratuit)
3. Copie ta clé

### 2. Configuration

Ouvre `config/config.php` et renseigne ta clé :

```php
define('TMDB_API_KEY', 'TA_CLE_API');
```

### 3. Prérequis PHP

Les extensions `openssl` et `curl` doivent être activées dans ton `php.ini` :

```ini
extension=openssl
extension=curl
```

### 4. Lancement

```bash
cd api_film
php -S localhost:8000
```

Ouvre [http://localhost:8000](http://localhost:8000) dans ton navigateur.

---

## Routes API

| Méthode  | URL                        | Description               |
|----------|----------------------------|---------------------------|
| `GET`    | `/`                        | Interface web             |
| `GET`    | `/movies?type=popular`     | Films populaires          |
| `GET`    | `/movies?type=top_rated`   | Films les mieux notés     |
| `GET`    | `/movies?type=upcoming`    | Films à venir             |
| `GET`    | `/movies?type=now_playing` | Films en salle            |
| `GET`    | `/movies/search?q=batman`  | Rechercher un film        |
| `GET`    | `/favorites`               | Liste des favoris         |
| `POST`   | `/favorites`               | Ajouter un favori         |
| `DELETE` | `/favorites?id=123`        | Supprimer un favori       |

---

## Exemples de requêtes

**Films populaires**
```
GET http://localhost:8000/movies?type=popular
```

**Recherche**
```
GET http://localhost:8000/movies/search?q=inception
```

**Ajouter un favori**
```
POST http://localhost:8000/favorites
Content-Type: application/json

{ "id": 27205, "title": "Inception", "poster_path": "/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg" }
```

**Supprimer un favori**
```
DELETE http://localhost:8000/favorites?id=27205
```

---

## Structure du projet

```
api_film/
├── index.php                   Point d'entrée + routeur
├── html/
│   └── index.html              Interface web
├── config/
│   └── config.php              Clé API et constantes
├── services/
│   └── TMDBService.php         Appels vers l'API TMDB
├── controllers/
│   ├── MovieController.php     Logique des films
│   └── FavoriteController.php  Logique des favoris
└── data/
    └── favorites.json          Favoris stockés (créé automatiquement)
```
