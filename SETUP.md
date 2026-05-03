# Setup Perpustakaan Digital

## Langkah-langkah

1. Buat database MySQL bernama `perpustakaan_db`

2. Jalankan perintah berikut di terminal (satu per satu):

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

3. Buka browser: http://localhost:8000

## Login Demo

| Role    | Email                  | Password |
|---------|------------------------|----------|
| Admin   | admin@perpus.com       | password |
| Petugas | petugas@perpus.com     | password |
