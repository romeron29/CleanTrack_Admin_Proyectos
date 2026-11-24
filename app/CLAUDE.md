# CleanTrack
Sistema de gestión de inmuebles, tareas y tiempos para empresas de limpieza.
Proyecto individual de la UTN (ISW-912). Se trabaja con Scrum y se entrega el 25/11/2026.

## Stack
Laravel, PostgreSQL (base: cleantrack), Blade para las vistas, diseño adaptable a teléfono.

## Reglas
- Trabajar una tarea por vez, identificada por su ID (T1, T4, US-01...).
- Cada historia debe cumplir sus criterios de aceptación y tener pruebas (php artisan test).
- Validar los datos en el servidor con Form Requests.
- Mensajes y textos de la interfaz en español.
- Commits con el formato "US-01: descripción (#número de issue)".
- No inventar funcionalidades fuera del Sprint Backlog.

## Sprint 1
Meta: configurar el entorno y permitir el registro de clientes y de sus inmuebles.
Comprometido: TEC, US-01 (clientes) y US-02 (inmuebles). Ampliado: US-03 (áreas) y US-04 (ficha).