<?php

namespace App\Http\Requests;

class UpdateCategoryRequest extends StoreCategoryRequest
{
    // Reutiliza authorize() y rules() de StoreCategoryRequest (DRY).
    // Si en el futuro difieren, sobreescribir rules() aquí.
}
