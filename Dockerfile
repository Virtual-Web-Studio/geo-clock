ARG PHP_VERSION=8.4

FROM php:${PHP_VERSION}-cli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install required tools
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    wget \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set PHP settings
RUN echo "date.timezone=UTC" > /usr/local/etc/php/conf.d/timezone.ini \
 && echo "memory_limit=256M" > /usr/local/etc/php/conf.d/memory_limit.ini

# Create non-root user with same UID/GID passed from host
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID appgroup && useradd -u $UID -g $GID -m appuser

WORKDIR /app

COPY . .

USER appuser
