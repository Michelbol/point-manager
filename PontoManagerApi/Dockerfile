FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG uid
ARG user

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  libzip-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  zip \
  unzip

# Clean cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-freetype

RUN docker-php-ext-install pdo_mysql bcmath exif gd zip

# Get latest Composer
COPY --from=composer:2.0.7 /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan commands
RUN useradd -G www-data,root -l -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
  chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Change current User to $user
USER $user
