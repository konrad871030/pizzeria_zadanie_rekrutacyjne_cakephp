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
