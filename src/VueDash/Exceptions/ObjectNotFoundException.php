<?php
/**
 * Project : aluminumz
 * User: palagornp
 * Date: 14/1/2018 AD
 * Time: 11:35
 */

namespace Palamike\VueDash\Exceptions;

use Exception;

class ObjectNotFoundException extends Exception {

	/**
	 * Create a new authentication exception.
	 *
	 * @param  string  $message
	 * @return void
	 */
	public function __construct($message = '')
	{

		if(! empty($message)) {
			parent::__construct($message);
		}
		else {
			parent::__construct(trans('exception.object_not_found'));
		}

	}

}