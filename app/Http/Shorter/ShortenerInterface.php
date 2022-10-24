<?php

    namespace App\Http\Shorter;

    interface ShortenerInterface
    {
        public function shortUrl(string $url): string;
    }
