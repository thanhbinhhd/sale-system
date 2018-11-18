<?php
 namespace App\Http\Requests;
 use Illuminate\Foundation\Http\FormRequest;
 class UpdateSlideRequest extends FormRequest {
    public function authorize() {
        return true;
    }
     public function rules(){
        $slideID = $this->input('id');
        return [
            'title'  => 'required|unique:slides,title,' . $slideID,
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