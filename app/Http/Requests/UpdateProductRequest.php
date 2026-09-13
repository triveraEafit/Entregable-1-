<?php

namespace App\Http\Requests;

class UpdateProductRequest extends StoreProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        // En edición la imagen es opcional aunque ya exista una.
        $rules['image'] = ['nullable', 'image', 'max:2048'];

        return $rules;
    }
}
