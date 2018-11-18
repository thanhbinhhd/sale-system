<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules(){
        $categoryID = $this->input('id');
        return [
            'name'  => 'required|unique:categories,name,' . $categoryID,
            'imagePath' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Name can not empty!',
            'name.unique' => 'Name was existed!',
            'imagePath.required'  => 'Image Link can not empty!',
        ];
    }
}
