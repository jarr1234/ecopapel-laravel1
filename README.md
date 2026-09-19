# Ecopapel migrado a Laravel

Conversión del proyecto PHP `mi_web` a estructura Laravel.

## Instalación rápida en XAMPP (Windows)
1. Descomprime como `C:\xampp\htdocs\mi_web_laravel`.
2. Abre una terminal dentro de la carpeta.
3. Ejecuta `composer install`.
4. Copia `.env.example` a `.env` (`copy .env.example .env`).
5. Ejecuta `php artisan key:generate`.
6. Verifica que XAMPP/MariaDB use la base existente `mi_web` en el puerto `3307`.
7. Ejecuta `php artisan serve`.
8. Abre `http://127.0.0.1:8000`.

La configuración de base incluida corresponde al proyecto original: host 127.0.0.1, puerto 3307, base mi_web, usuario root y contraseña vacía.

## Migrado
Inicio, login/logout, registro/verificación, productos/filtros/búsqueda, carrito persistente, compra/ventas/stock y panel admin básico para productos, usuarios, categorías y ventas. Se conservaron CSS, imágenes, tickets y cortes existentes.

## Nota
Los PDF históricos se conservan. La generación de nuevos tickets/cortes con FPDF del proyecto legado no se incluyó en esta primera conversión; el flujo de compra y ventas sí queda en Laravel.
