<?php

    namespace App\Http\Shorter;

    use Illuminate\Support\Facades\Http;

    class TinyProvider implements ShortenerInterface
    {
        /**
         * Generate short url from tinyurl.com
         *
         * @param string $url
         * @return object
         */
        public function shortUrl(string $url): string
        {
            $responseData = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.tiny.token'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://api.tinyurl.com/create', [
                "url"    => $url,
                "domain" => config('services.tiny.domain'),
            ]);

            // Return PHP object for further processing
            return $responseData->object()->data->tiny_url;

        }
    }
