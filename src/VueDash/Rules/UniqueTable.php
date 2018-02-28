<?php

namespace Palamike\VueDash\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class UniqueTable implements Rule
{

	private $data;

    /**
     * Create a new rule instance.
     * @param Request $request http request
     * @param string $prop property name
     * @return void
     */
    public function __construct(Request $request, $prop)
    {
        $this->data = $request->get($prop);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

    	if(count($this->data) < 2){
    		return true;
	    }

        if(str_contains($attribute, '.')){

        	$fields = explode('.', $attribute);

			if(count($fields) === 3){

				$index = $fields[1];
				$field = $fields[2];

				$dataLength = count($this->data);

				$result = true;

				for ($i = 0; $i < $dataLength; $i++) {

					if(intval($index) !== $i){
						$row = $this->data[$i];
						if( $index > $i && $row[$field] === $value) {
							$result = false;
						}
					}

				}

				return $result;

			}
			else {
				return true;
			}

        }
        else{
        	return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique_table');
    }
}
