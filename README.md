# naava_vue

## Laravel setup
```
- cd <project directory>/api/local
- composer install
- php artisan key:generate
- create database in your localhost
- rename .env.example file to .env
- set database settings in .env file and save it.
- run following command
```
```
php artisan migrate
```

## Project setup
- On root directory run following commands

```
- npm install
- npm run serve
```
- set api path according to the local settings of laravel setup in `src\environments\environment.json`

### Compiles and minifies for production
```
npm run build
```
- Run following commands on root directory after build
```
-  mkdir www
-  cp -r dist/* ./www
```

- open browser and go to [http://localhost/<project_directory>/www](http://localhost/<project_directory>/www) for working build