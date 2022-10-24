<?php

    namespace Tests\Feature;

    use Illuminate\Support\Facades\Http;
    use Tests\TestCase;

    class ShortyTest extends TestCase
    {
        /**
         * A basic status assert.
         *
         */
        public function test_api_health()
        {
            $response = $this->get('/');

            $response->assertStatus(200);
        }

        public function test_api_short_url()
        {
            $fixtureData = file_get_contents(base_path('tests/Fixtures/shortyCreatedResponse.json'));

            Http::fake([
                url('/api/short') => Http::response($fixtureData, 401, [
                    'Content-Type' => 'application/json',
                ]),
            ]);

            $this->assertEquals(
                [
                    "url"        => "https://example.com/testShorUrl",
                    "shortedUrl" => "https://bit.ly/3SD8bAQ"
                ],
                Http::get(url('/api/short'))->json()
            );

        }
    }
