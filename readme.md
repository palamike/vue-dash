![version](https://img.shields.io/badge/1.0.23-stable-brightgreen.svg)

# Introduction

This package is Laravel 5.6 - Vue 2.x Admin Panel projects. 
This project use element.eleme.io for components and provide generator to quickly create laravel and vue related file.
Plus generate the route automatically.

## Installation for new Laravel Projects or Existing Projects

### 1. Install Package via composer

```
composer require palamike/vue-dash
```

### 2. Remove Laravel default files

1. default migration files (users and password_resets tables)
2. default factory files (user factory)
3. default model file (user model)

### 3. Publish Assets

use the artisan command to publish assets

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider"
```

### 4.1 Add dependency to package.json

```
see the dependencies in package at vue-dash/package.json
```

### 4.2 If you install fresh laravel use this command to replace the package.json file

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --tag="package-json" --force
```

### 5.1 add laravel mix codes

```
see code in package at vue-dash/webpack.mix.js
```

**Notes** We must have `/**MIX_REPLACER**/` string in the webpack.mix.js to auto generate the mix entries.

### 5.2 If you install fresh laravel use this command to replace webpack.mix.js

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --tag="mix" --force
```

### 6. add the following code to the routes/web.php file.

```php
Route::namespace('Modules')->middleware(['auth'])->group(function () {
    /**ROUTE_REPLACER**/
});
```

### 7. add middleware from spatie package to $routeMiddleware variable at app/Http/Middleware/Kernel.php

```
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
``` 

### 8. add the following seeder to main seeder file
       
```       
$this->call(PermissionsTableSeeder::class);
$this->call(SettingsTableSeeder::class);
$this->call(RolesTableSeeder::class);
$this->call(UsersTableSeeder::class);
```

### 9. Update config auth.php

update config/auth.php change App\Model\User references to Palamike\VueDash\Models\User

### 10. Run the following commands.

**Quick Notes:** if you need to create directory app/Models, app/Http/Controllers/Modules, resources/view/modules if your project does not have.

```
composer dump-autoload
```

```
php artisan migrate:fresh --seed
```

```
npm install
```

```
npm run dev
```
Now you can open your project in the web browser and shoud see the login panel. 

## Usage

### Preparation

Create app/Models, app/Http/Controllers/Modules , resources/views/modules manually

### Generate new module

```
php artisan make:module ParentNames ModuleNames
```

**Note** Parent Name and Module Name must be prural forms.  
**Important** You must generate migration for database manually.  
**Options** use --no-model options will not generate model

### Migration

In your migration files you need..  
1. id of the table must be bigInteger
2. add the following fields to each object table you create.

```
$table->bigInteger('created_id')->unsigned();
$table->bigInteger('updated_id')->unsigned()->nullable();
```         

### Modify Controller

You can modify the newly generated modules at app/Http/Controllers/Modules

### Override Package Routes

open your config/app.php and register vue-dash package before `App\Providers\RouteServiceProvider::class`

### Modify Models

You can modify the newly generated model at app/Models

### Modify Frontend assets

You must modify frontend assets at resources/assets/js/components/modules

### Modify Javascript lang

You must modify javascript lang file for translation at resources/assets/js/lang

### Add Sidebar Menu

You can add sidebar menu at resources/assets/js/data/sidebar.js

## Updating

When ever packages update you can use this command to update assets.

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --tag="js-elements" --force 
```

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --tag="sass-elements" --force 
```

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --tag="view" --force 
```

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider" --tag="php-lang" --force 
```

## Upgrade from Previous VueDash before 1.0.0

### Before install please ...

remove file from app/Console/Commands
- MakeModule.php

remove app/Functions and edit composer.json autoload section remove this file.  
remove unused controller from app/Http/Controllers which has the following files
- Auth
- Modules/Users
- Modules/Settings
- ProfileController
- HomeController 
- ModuleController

remove file from app/Exceptions folder
- BusinessException
- ObjectNotFoundException

remove file from app/Providers
- SettingServiceProvider

remove App\Providers\SettingServiceProvider::class from config/app.php

remove file from app/Models
- User
- Setting

remove file from app/Rules
- UniqueTable

replace namespace for ModuleController in every file to Palamike\VueDash\Http\Controllers\Modules\ModuleController  
replace namespace for ObjectNotFoundException in every file to Palamike\VueDash\Exceptions\ObjectNotFoundException  
replace namespace for UniqueTable in every file to use Palamike\VueDash\Rules\UniqueTable;

remove file from database/migrations
- ..._create_permission_tables.php  
- ..._create_setting_table

edit routes/web.php file and remove the following routes
1. /
2. /home
3. /profile
4. /users/roles
5. /users/users
6. /settings/general-settings
7. Auth::routes()

### 1. Install Package via composer

```
composer require palamike/vue-dash
```

### 2. Publish assets using

```
php artisan vendor:publish --provider="Palamike\VueDash\Providers\VueDashServiceProvider"
```

### 3. Move Files

move from resources/assets/js/components/data to resources/assets/js/data (replace published)

### 4. Rename Files 

1. change from resources/assets/sass/pmf-variables.sass to resources/assets/sass/vue_dash_variables.sass 
2. change from resources/assets/js/app.js to resources/assets/js/vue-dash.js
3. change from resources/assets/js/bootstrap.js to resources/assets/js/boot.js 

### 5. Update View files

Update views file which reference `layouts.generic` to `vueDash::layouts.generic`

### 6. Update Translation keys

Existing php translation key must add `vueDash::` in front of key.

### 7. Update webpack.mix.js

1. Change sass endpoint from app.js to vue-dash.js
2. Change sass endpoint from app.scss to vue_dash.scss

### 8. Update config

update config/auth.php change App\Model\User references to Palamike\VueDash\Models\User

### 9. Update Seeder & Factory

1. update UsersTableSeeder change App\Model\User references to Palamike\VueDash\Models\User
2. update SettingsTableSeeder change change App\Model\Settings references to Palamike\VueDash\Models\Setting
3. update UserFactory change App\Model\User references to Palamike\VueDash\Models\User

### 10. Run the following commands

```
composer dump-autoload
```

```
php artisan migrate:fresh --seed
```

```
npm install
```

```
npm run dev
```

### 11. Cleanup 

1. You can remove old resources/views/layouts
2. You can remove old resources/views/generator
3. You can remove old resources/views/modules/settings/general_settings.blade.php
4. You can remove old resources/views/modules/users/users.blade.php
5. You can remove old resources/views/modules/users/roles.blade.php