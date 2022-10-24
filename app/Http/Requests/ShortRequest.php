<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Set provider and url validation
     *
     * @property string $provider
     * @property string $url
     */
    class ShortRequest extends FormRequest
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
            return [
                'url'      => 'required|url',
                'provider' => 'required|in:bitly,tiny',
            ];
        }

    }
