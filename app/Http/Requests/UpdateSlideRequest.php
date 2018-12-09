<?php
 namespace App\Http\Requests;
 use Illuminate\Foundation\Http\FormRequest;
 class UpdateSlideRequest extends FormRequest {
    public function authorize() {
        return true;
    }
     public function rules(){
        $slideID = $this->input('slide-id');
        return [
            'title'  => 'required|unique:slides,title,' . $slideID,
            'image'     => 'mimes:jpeg,bmp,png,jpg'
        ];
    }

}