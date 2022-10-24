<?php

    namespace Tests\Unit\ShorterFactory;

    use Illuminate\Support\Facades\Http;
    use Tests\TestCase;

    class TinyUrlApiTest extends TestCase
    {

        /**
         * A basic unit test example.
         *
         * @return void
         */
        public function test_check_tiny_create_endpoint(): void
        {

            $body = file_get_contents(base_path('tests/Fixtures/tinyUrlCreatedData.json'));

            Http::fake([
                'https://api.tinyurl.com/create' => Http::response($body, 200, []),
            ]);

            $this->assertEquals(
                [
                    'data'   => [
                        'domain'     => 'tinyurl.com',
                        "alias"      => "yc57ch7p",
                        "deleted"    => false,
                        "archived"   => false,
                        "analytics"  => [
                            "enabled" => true,
                            "public"  => false,
                        ],
                        "tags"       => [],
                        "created_at" => "2022-10-21T00:23:44+00:00",
                        "expires_at" => null,
                        "tiny_url"   => "https://tinyurl.com/yc57ch7p",
                        "url"        => "https://www.example.com/my-really-long-link-that-I-need-to-shorten/84378949"
                    ],
                    'code'   => 0,
                    "errors" => []
                ],
                Http::get('https://api.tinyurl.com/create')->json()
            );

            // We can also use the TinyUrl API to make native assertions...
            /*            $this->assertEquals(
                            json_decode($body, true),
                            Http::get('https://api.tinyurl.com/create')->json()
                        );*/

        }

    }
