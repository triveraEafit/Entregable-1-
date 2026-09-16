<?php

namespace App\Http\Requests;

class UpdateBrandRequest extends StoreBrandRequest
{
    // Reutiliza authorize() y rules() de StoreBrandRequest (DRY).
    // Si en el futuro difieren, sobreescribir rules() aquí.
}
