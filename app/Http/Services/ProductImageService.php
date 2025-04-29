<?php

namespace App;

use Illuminate\Http\UploadedFile;

class ProductImageService
{
    public function storeImage(UploadedFile $image)
    {
        return $image->store('products', 'public');
    }
}
