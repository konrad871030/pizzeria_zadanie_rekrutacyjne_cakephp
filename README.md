# pizzeria_zadanie_rekrutacyjne_cakephp
Realizacja w CakePHP.

## Wymagania

- Docker Desktop (wlaczony)
- Docker Compose

## Uruchomienie srodowiska

W katalogu projektu uruchom:

```bash
docker compose up -d --build
```

Po starcie aplikacja bedzie dostepna pod adresem:

- http://localhost:8765

## Inicjalizacja bazy i danych startowych

Po pierwszym uruchomieniu wykonaj migracje:

```bash
docker compose exec cakephp php bin/cake.php migrations migrate
```

## Zatrzymanie srodowiska

```bash
docker compose down
```

## Konfiguracja bazy MySQL (Docker)

- host: `mysql`
- port: `3306`
- baza: `my_app`
- uzytkownik: `my_app`
- haslo: `secret`
- root haslo: `root`

W kontenerze aplikacji ustawione jest:

- `DATABASE_URL=mysql://my_app:secret@mysql:3306/my_app?encoding=utf8mb4`

## Moduly aplikacji

- Frontend: formularz zamowienia + menu + live licznik kolejki i ETA (`/`).
- Backend: worker CLI obslugujacy kolejke zamowien.

## Uruchomienie backend workera

Tryb ciagly (co 10 minut obsluguje jedno zamowienie):

```bash
docker compose exec cakephp php bin/cake.php orders-worker
```

Tryb jednorazowy (do testow):

```bash
docker compose exec cakephp php bin/cake.php orders-worker --once
```

Opcjonalne parametry:

- `--interval 600` - interwal petli w sekundach
- `--threshold 5` - prog "dlugiej kolejki" logowany jako warning

## Testy jednostkowe workera

Uruchomienie testow tylko dla workera:

```bash
docker compose exec cakephp php vendor/bin/phpunit tests/TestCase/Command/OrdersWorkerCommandTest.php
```

Uruchomienie calego zestawu testow:

```bash
docker compose exec cakephp php vendor/bin/phpunit
```
