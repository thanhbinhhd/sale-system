<?php
 namespace App\Http\Requests;
 use Illuminate\Foundation\Http\FormRequest;
 class CreateSlideRequest extends FormRequest {
    public function authorize() {
        return true;
    }
     public function rules(){
        return [
            'title'  => 'required|unique:slides',
            'link' => 'required'
        ];
    }
     public function messages(){
        return [
            'title.required' => 'Title can not empty!',
            'title.unique' => 'Title was existed!',
            'link.required'  => 'Image Link can not empty!',
        ];
    }
}