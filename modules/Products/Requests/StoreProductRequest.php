<?php

declare(strict_types=1);

namespace Modules\Products\Requests;

use Core\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:100|unique:products,sku',
            'slug' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|integer',
            'status' => 'required|in:active,inactive,draft',
            'name_en' => 'required|string|max:255',
            'name_tr' => 'nullable|string|max:255',
            'name_cs' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_tr' => 'nullable|string',
            'description_cs' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
        ];
    }
}
