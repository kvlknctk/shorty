<?php

    namespace App\Http\Shorter;

    class Shorter
    {
        /**
         * Set the short url provider
         *
         * @param string $provider
         *
         * @return ShortenerInterface
         */
        public function setShorter(string $provider): ShortenerInterface
        {
            return match ($provider) {
                'tiny' => new TinyProvider(),
                'bitly' => new BitlyProvider(),
                default => throw new \InvalidArgumentException('Shorter provider service not found.'),
            };
        }
    }
