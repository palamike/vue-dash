<?php
/**
 * Project : vue-dash
 * User: palagornp
 * Date: 17/2/2018 AD
 * Time: 13:46
 */

/**
 *
 * get the Controller namespace string
 *
 * @param string $namespace
 *
 * @return string
 */
function getVueDashControllerNamespace($namespace = '') {

	$ns = 'Palamike\\VueDash\\Http\\Controllers';

	if(! empty($namespace)) {
		return $ns.'\\'.$namespace;
	}
	else {
		return $ns;
	}
}