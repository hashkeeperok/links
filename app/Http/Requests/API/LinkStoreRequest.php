<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class LinkStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'long_url' => ['required_without:links', 'string', 'active_url'],
            'title' => ['string'],
            'tags' => ['array'],
            'tags.*' => ['string'],
            'links' => ['array'],
            'links.*.long_url' => ['required', 'string', 'active_url'],
            'links.*.title' => ['required', 'string'],
            'links.*.tags' => ['array'],
            'links.*.tags.*' => ['string'],
        ];
    }
}
