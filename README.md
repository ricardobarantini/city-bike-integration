# Application City Bike Integration

## Problems during the development

There is a CORS problem to make requests from the Vue component using `axios` to an external API, because of that I solved this issue running a cron job to update or insert each item from the api to a local database. This job needs 10 minutes to run and runs every 15 minutes.

## How to run the project

### Prepare the .env file

`cp .env.example .env`

Updates the `DB_HOST=127.0.0.1` key to `DB_HOST=mapbikes-db`

Update the `DB_DATABASE=laravel` key to `DB_DATABASE=mapbikes`

Updates the `DB_PASSWORD=` key to `DB_PASSWORD=root`

### Build and up the docker

Inside the application folder run:

`docker-compose build app`

`docker-compose up -d`

### Installing the project vendors

`npm install`

`docker-compose exec app composer install`

### Key Generate

Runs `docker-compose exec app php artisan key:generate`

### Database migrations

Inside the container, just run:

`docker-compose exec app php artisan migrate`

### Compiling the assets

`npm run dev`

**That's it!**

You can access the project at `localhost:8000`
