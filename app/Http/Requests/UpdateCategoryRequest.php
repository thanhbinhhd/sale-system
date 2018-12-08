<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\CategoryRepository;

class UpdateCategoryRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules(CategoryRepository $category){
        $categoryID = $this->input('category-id');
        return [
            'name'  => 'required|unique:categories,name,' . $categoryID,
            'image'     => 'mimes:jpeg,bmp,png,jpg'
        ];
    }

}
