# Challenge 1 - 4IW3

ERP/CRM business management application

## Getting Started

Follow these steps to set up the project locally:

### Requirements

-   [PHP](https://www.php.net/) >= 8.2
-   [Composer](https://getcomposer.org/)
-   [Node.js](https://nodejs.org/en)
-   [NPM](https://www.npmjs.com/) or [Yarn](https://yarnpkg.com/)
-   [Symfony CLI](https://symfony.com/download)

### Installation

1. Clone this repository:

    ```bash
    git clone https://github.com/NicolasFrouin/challenge1_4iw3.git
    ```

2. Install PHP dependencies using Composer:

    ```bash
    cd challenge1_4iw3
    composer install
    ```

3. Install JavaScript dependencies using NPM or Yarn:

    ```bash
    npm install   # or yarn install
    ```

4. Build assets with Tailwind CSS:

    ```bash
    npm run build   # or yarn build
    ```

5. Set up your environment variables by copying the `.env` file:

    ```bash
    cp .env .env.local
    ```

    Make necessary changes in the `.env.local` file according to your local environment.

    By default, in `dev` mode, the database is configured to use SQLite which doesn't require any additional setup.  
    The database will be stored in the `var` directory as `data.dev.sqlite`.  
    If you want to use another database, you can do so by setting the `DATABASE_URL` environment variable in a `.env.dev.local` file.

6. Create the database and load fixtures:

    ```bash
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
    ```

## Usage

Start the Symfony development server:

```bash
composer run-script serve
```
