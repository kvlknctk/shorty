<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\ShortRequest;
    use App\Http\Shorter\Shorter;
    use Exception;

    class ShortController extends Controller
    {
        /**
         * Create a short url with provider
         *
         * @throws Exception
         */
        public function create(ShortRequest $request, Shorter $shorter): object
        {

            // Set the shorter provider
            $shorterProvider = $shorter->setShorter($request->provider);

            // Short the url
            $shortedUrl = $shorterProvider->shortUrl($request->url);

            // Return the shorted url
            return response()->json([
                'url'        => $request->url,
                'shortedUrl' => $shortedUrl,
            ]);
        }

    }
