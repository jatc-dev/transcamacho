# Transcamacho Platform

Modernización independiente de Transcamacho: Next.js + TypeScript, Prisma/PostgreSQL (Neon), Better Auth y despliegue Docker en Render.

## Requisitos
- Node.js 22+
- PostgreSQL / Neon
- `DATABASE_URL`, `BETTER_AUTH_SECRET` y `BETTER_AUTH_URL`

## Desarrollo
```bash
npm install
npx prisma generate
npx prisma migrate dev --name init
npm run dev
```

## Despliegue
La imagen Docker escucha en `PORT` (3000 por defecto). Ejecutar migraciones con `npx prisma migrate deploy` antes de habilitar tráfico. Configurar secretos exclusivamente en el gestor de variables del servicio.

## Seguridad
No contiene datos importados del SQL histórico. No usar ni reactivar las credenciales MariaDB que quedaron publicadas en el repositorio legado. Crear la primera cuenta administradora por un proceso de bootstrap seguro antes de abrir el registro.
