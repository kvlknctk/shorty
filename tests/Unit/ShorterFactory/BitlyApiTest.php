<?php

    namespace Tests\Unit\ShorterFactory;

    use Illuminate\Support\Facades\Http;
    use Tests\TestCase;

    class BitlyApiTest extends TestCase
    {

        /**
         * We can perform mock unit tests by taking the generated
         * bitly response to the fixtures directory before the test.
         *
         * @return void
         */
        public function test_check_bitly_create_endpoint(): void
        {

            $body = file_get_contents(base_path('tests/Fixtures/bitlyCreatedResponse.json'));

            Http::fake([
                'https://api-ssl.bitly.com/v4/shorten' => Http::response($body, 200, []),
            ]);

            $this->assertEquals(
                [
                    "url"        => "https://example.com/testShorUrl",
                    "shortedUrl" => [
                        "created_at"      => "2022-10-24T10:40:37+0000",
                        "id"              => "bit.ly/3SD8bAQ",
                        "link"            => "https://bit.ly/3SD8bAQ",
                        "custom_bitlinks" => [],
                        "long_url"        => "https://example.com/testShorUrl",
                        "archived"        => false,
                        "tags"            => [],
                        "deeplinks"       => [],
                        "references"      => [
                            "group" => "https://api-ssl.bitly.com/v4/groups/BmanhiGvZgc"
                        ]
                    ]
                ],
                Http::get('https://api-ssl.bitly.com/v4/shorten')->json()
            );

            // We can also use the Bit.ly API to make native assertions...
            /*            $this->assertEquals(
                            json_decode($body, true),
                            Http::get('https://api-ssl.bitly.com/v4/shorten')->json()
                        );*/

        }


        /**
         * It controls the error that will occur in case of token problem.
         *
         * @return void
         */
        public function test_check_bitly_forbiden_response(): void
        {

            $fixtureResponse = file_get_contents(base_path('tests/Fixtures/bitlyForbiddenResponse.json'));
            $statusCode      = 403;

            Http::fake([
                'https://api-ssl.bitly.com/v4/shorten' => Http::response($fixtureResponse, $statusCode, []),
            ]);

            $response = Http::get('https://api-ssl.bitly.com/v4/shorten');
            $this->assertEquals($statusCode, $response->status());

        }

    }
