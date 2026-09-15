<?php

namespace App\Http\Requests;

/**
 * Editing a product uses the same authorization and rules as creating it. The image stays
 * optional, so the current one is kept when the admin does not upload a new file.
 */
class UpdateProductRequest extends StoreProductRequest {}
