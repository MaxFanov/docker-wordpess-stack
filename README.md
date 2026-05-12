# WordPress Environment

This repository contains the configuration for a Docker-based WordPress development environment for the any project.

It includes services for WordPress, a database (MySQL), and Redis for object caching.

## Prerequisites

Before you begin, ensure you have the following installed on your local machine:
*   [Docker](https://docs.docker.com/get-docker/)
*   [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd project
    ```

2.  **Create an environment file:**
    It is recommended to have a `.env.example` file in your project. You can create your local configuration by copying it:
    ```bash
    cp .env.example .env
    ```
    Update the `.env` file with your desired credentials and settings. The WordPress security salts and keys can be generated from the official WordPress salt generator.

3.  **Start the services:**
    Build and run the Docker containers in detached mode:
    ```bash
    docker-compose up -d --build
    ```

4.  **Access the site:**
    Once the containers are running, you can access the WordPress site at `http://localhost` (or the host you configured). The first time you access it, you will be guided through the WordPress installation process.

## Configuration

The environment is configured using environment variables defined in a `.env` file at the root of the project. These are read by the `wp-config.php` file.

### Environment Variables

| Variable                    | Default         | Description                                                                 |
| --------------------------- | --------------- | --------------------------------------------------------------------------- |
| `PROJECT_NAME`              | `wordpress`     | The project name, used for the cache key salt.                              |
| `WORDPRESS_DB_NAME`         | `wordpress`     | The database name.                                                          |
| `WORDPRESS_DB_USER`         | `wordpress`     | The database user.                                                          |
| `WORDPRESS_DB_PASSWORD`     | `root`          | The database password.                                                      |
| `WORDPRESS_DB_HOST`         | `db`            | The database service hostname.                                              |
| `WORDPRESS_TABLE_PREFIX`    | `wp_`           | The prefix for WordPress database tables.                                   |
| `WORDPRESS_REDIS_HOST`      | `redis`         | The Redis service hostname.                                                 |
| `WORDPRESS_AUTH_KEY`        | `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_SECURE_AUTH_KEY` | `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_LOGGED_IN_KEY`   | `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_NONCE_KEY`       | `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_AUTH_SALT`       | `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_SECURE_AUTH_SALT`| `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_LOGGED_IN_SALT`  | `put-your-...`  | See WordPress Salts.                                                        |
| `WORDPRESS_NONCE_SALT`      | `put-your-...`  | See WordPress Salts.                                                        |

### Services

This setup is designed to work with a `docker-compose.yml` file that defines the following services:

*   `wordpress`: The main PHP-FPM/Apache container running WordPress.
*   `db`: The MySQL database container.
*   `redis`: The Redis container for object caching.
*   A reverse proxy (e.g., Nginx) to handle incoming requests and SSL termination.

## Development

### Debugging

Debugging is enabled by default in this configuration:
*   `WP_DEBUG`: `true`
*   `WP_DEBUG_LOG`: `true` - Errors are logged to `/wp-content/debug.log` inside the `wordpress` container.
*   `WP_DEBUG_DISPLAY`: `true` - Errors will be displayed in the browser.

### WP-Cron

The built-in WordPress cron (`wp-cron.php`) is disabled via `DISABLE_WP_CRON: true`. It is expected to be triggered by an external process, such as a `cron` job on the host or a dedicated `cron` container (enabled by default), running a command like:
```bash
docker-compose exec wordpress wp cron event run --due-now
```

### WP-CLI

You can run WP-CLI commands by executing them inside the `wordpress` container:
```bash
docker-compose exec wordpress wp <command>
```
For example, to list installed plugins:
```bash
docker-compose exec wordpress wp plugin list
```

