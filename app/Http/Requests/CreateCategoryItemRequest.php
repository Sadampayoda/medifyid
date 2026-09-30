<?php

namespace App\Http\Requests;

use App\Models\CategoryItem;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return CategoryItem::rules();

    }

    public function message()
    {
        return CategoryItem::ruleMessages();
    }
}
