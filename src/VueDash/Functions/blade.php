<?php
/**
 * Project : vue-dash
 * User: palamike
 */

/**
 * get auth user info (need to use after authenticate)
 * @return array|string
 */
function authUserInfo(){

	if(! auth()->check()){
		return '';
	}

	/**
	 * @var $user \App\Models\User
	 */
	$user = auth()->user();
	$roleName = $user->getRoleNames()->first();
	$permissions = $user->getAllPermissions();
	$plucked = $permissions->pluck('name');

	return [ 'user_name' => $user->name, 'role_name' => $roleName, 'permissions' => $plucked ];
}