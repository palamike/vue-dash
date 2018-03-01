##Existing Laravel Project

remove default laravel migrations if you already have or you can manual modify this file later

remove default laravel UserFactory if you already have or you can manual modify this file later

publish all files no forces

##Add Sass endpoint in mix

##Add Replacer Wording in mix, routes

Route::namespace('Modules')->middleware(['auth'])->group(function () {
    /\*\*ROUTE_REPLACER\*\*/
});

add middleware from

'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,

##Upgrade from Previous VueDash

publish all files no forces

Move js/components/data to js/data

##change file pmf-variables to variables. bootstrap.js to boot.js

## View name must begin with vueDash:: especially when extends layout from package

## translation key must add vueDash::

php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --force

update webpack.mix.js to reflex new sass files vue_dash.scss and vue-dash.js

change App\Model\User references to Palamike\VueDash\Models\User in auth config and seeder
change App\Model\Settings references to Palamike\VueDash\Models\Setting in seeder and setting related controller

## New Project

remove default laravel migrations

remove default laravel UserFactory

add seeder to main seeder file

$this->call(PermissionsTableSeeder::class);
$this->call(SettingsTableSeeder::class);
$this->call(RolesTableSeeder::class);
$this->call(UsersTableSeeder::class);

add middleware from spatie

'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,