<?php

declare(strict_types=1);

namespace Modules\Products\Requests;

use Core\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public int|string|null $productId = null;

    public function forProduct(int|string $id): static
    {
        $this->productId = $id;

        return $this;
    }

    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:100|unique:products,sku,' . $this->productId,
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
