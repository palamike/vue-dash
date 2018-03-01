<?php
/**
 * Project : vue-dash
 * User: palamike
 * Date: 17/2/2018 AD
 * Time: 13:30
 */

Route::get('/', function () {
	return redirect('/home');
})->middleware('web');

Route::namespace(getVueDashControllerNamespace())->middleware('web')->group(function(){
	Auth::routes();
});

Route::namespace(getVueDashControllerNamespace('Modules'))->middleware(['web','auth'])->group(function () {
	Route::get( '/home', 'HomeController@index' )->name( 'home' );
	Route::get( '/profile', 'ProfileController@index' )->name( 'profile' )->middleware( 'permission:profile_update' );
	Route::post( '/profile/view', 'ProfileController@view' )->name( 'profileView' )->middleware( 'permission:profile_update' );
	Route::post( '/profile/update', 'ProfileController@update' )->name( 'profileUpdate' )->middleware( 'permission:profile_update' );

	Route::get( '/users/roles', 'Users\RoleController@index' )->name( 'roles' )->middleware( 'permission:role_view' );
	Route::post( '/users/roles/grid', 'Users\RoleController@grid' )->name( 'rolesGrid' )->middleware( 'permission:role_view' );
	Route::post( '/users/roles/view', 'Users\RoleController@view' )->name( 'rolesView' )->middleware( 'permission:role_view' );
	Route::post( '/users/roles/create', 'Users\RoleController@create' )->name( 'rolesCreate' )->middleware( 'permission:role_add' );
	Route::post( '/users/roles/update', 'Users\RoleController@update' )->name( 'rolesUpdate' )->middleware( 'permission:role_edit' );
	Route::post( '/users/roles/delete', 'Users\RoleController@delete' )->name( 'rolesDelete' )->middleware( 'permission:role_delete' );
	Route::post( '/users/roles/delete-selected', 'Users\RoleController@deleteSelected' )->name( 'rolesDeleteSelected' )->middleware( 'permission:role_delete' );
	Route::post( '/users/roles/permissions', 'Users\RoleController@permissions' )->name( 'rolesPermissionsOption' )->middleware( 'permission:role_view' );

	Route::get( '/users/users', 'Users\UserController@index' )->name( 'users' )->middleware( 'permission:user_view' );
	Route::post( '/users/users/grid', 'Users\UserController@grid' )->name( 'usersGrid' )->middleware( 'permission:user_view' );
	Route::post( '/users/users/view', 'Users\UserController@view' )->name( 'usersView' )->middleware( 'permission:user_view' );
	Route::post( '/users/users/create', 'Users\UserController@create' )->name( 'usersCreate' )->middleware( 'permission:user_add' );
	Route::post( '/users/users/update', 'Users\UserController@update' )->name( 'usersUpdate' )->middleware( 'permission:user_edit' );
	Route::post( '/users/users/delete', 'Users\UserController@delete' )->name( 'usersDelete' )->middleware( 'permission:user_delete' );
	Route::post( '/users/users/delete-selected', 'Users\UserController@deleteSelected' )->name( 'usersDeleteSelected' )->middleware( 'permission:user_delete' );
	Route::post( '/users/users/roles', 'Users\UserController@roles' )->name( 'usersRolesOption' )->middleware( 'permission:user_view' );

	Route::get( '/settings/general-settings', 'Settings\GeneralSettingController@index' )->name( 'generalSettings' )->middleware( 'permission:general_setting_update' );
	Route::post( '/settings/general-settings/save', 'Settings\GeneralSettingController@save' )->name( 'generalSettingsSave' )->middleware( 'permission:general_setting_update' );
	Route::post( '/settings/general-settings/view', 'Settings\GeneralSettingController@view' )->name( 'generalSettingsView' )->middleware( 'permission:general_setting_update' );
});