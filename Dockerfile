# ============================================================
# Etapa 1: dependencias
# ============================================================
FROM node:22-alpine AS deps
RUN apk add --no-cache libc6-compat
WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

# ============================================================
# Etapa 2: builder (aquí se necesita BETTER_AUTH_SECRET)
# ============================================================
FROM node:22-alpine AS builder
WORKDIR /app

# Argumentos de construcción que Render inyectará
ARG BETTER_AUTH_SECRET
ARG DATABASE_URL

# Se convierten en variables de entorno para el proceso de build
ENV BETTER_AUTH_SECRET=$BETTER_AUTH_SECRET
ENV DATABASE_URL=$DATABASE_URL
ENV NODE_ENV=production

COPY --from=deps /app/node_modules ./node_modules
COPY . .

RUN npx prisma generate && npm run build

# ============================================================
# Etapa 3: runner (imagen final ligera)
# ============================================================
FROM node:22-alpine AS runner
WORKDIR /app

ENV NODE_ENV=production

# Variables necesarias también en runtime
ENV BETTER_AUTH_SECRET=$BETTER_AUTH_SECRET
ENV DATABASE_URL=$DATABASE_URL

COPY --from=builder /app/.next ./.next
COPY --from=builder /app/node_modules ./node_modules
COPY --from=builder /app/package.json ./package.json
COPY --from=builder /app/public ./public

EXPOSE 3000

CMD ["npm", "start"]
