<?php

    namespace App\Http\Shorter;

    use Illuminate\Support\Facades\Http;

    class BitlyProvider implements ShortenerInterface
    {
        /**
         * Generate short url from bit.ly
         *
         * @param string $url
         * @return object
         */
        public function shortUrl(string $url): object
        {
            $responseData = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.bitly.token'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://api-ssl.bitly.com/v4/shorten', [
                "long_url" => $url,
                "domain"   => config('services.bitly.domain'),
            ]);

            // Return PHP object for further processing
            return $responseData->object();
        }
    }
