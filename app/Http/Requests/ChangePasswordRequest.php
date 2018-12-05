<?php

namespace App\Http\Requests\User;


use App\Http\Requests\JsonFormRequest;

class ChangePasswordRequest extends JsonFormRequest
{
	public function rules()
	{
		return [
			'old_password'      => 'required|min:6',
			'new_password'  => 'required|confirmed|min:6'
		];
	}
}
