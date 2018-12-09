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
            'image'     => 'required|mimes:jpeg,bmp,png,jpg'
        ];
    }

}