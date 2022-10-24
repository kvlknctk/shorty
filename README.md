### Requirements
This package has the following requirements:

- PHP 8.0 or higher
- Node.js 14.15.0 or higher

## Installation
You can easily install this package using Composer, by running the following command:

```bash
git clone https://github.com/kvlknctk/shorty.git
cp .env.example .env
```
Notice: You need to set tiny and bitly api keys in .env file.
```bash
composer update
npm install 
```

## Run Project 
You can easily install this package using Composer, by running the following command:

```bash
php artisan serve 
```

## Hot reload for React
You can use hot reload for a good developer experience.
For this, you need to have your project up and running with `php artisan serve` first.
```bash
npm dev
```


# To add new shortener service
## Create your own  URL shorter provider file 
You can create your own shortener service as follows. 
To do this, you can go to `app/Http/Shorter` folder. You have to return string value from your provider
```php
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
```

## Connect your new service to factory
then you need to connect the provider you added to the factory. For this, add as shown as an example.
Use this file to do this. `app/Http/Shorter/Shorter.php`


```php
public function setShorter(string $provider): ShortenerInterface
{
    return match ($provider) {
        'tiny' => new TinyProvider(),
        'bitly' => new BitlyProvider(),
        // Add here your new provider with your custom key
        // for example 'myprovider' => new MyProvider()
        default => throw new \InvalidArgumentException('Shorter provider service not found.'),
    };
}
```



## Edit Request Validation
Users need to specify the provider in order to make a request.
We have a Request file for this. 
You need to specify the `myprovider` name you have added here.
`app/Http/Requests/ShorterRequest.php`

```php
/**
 * Get the validation rules that apply to the request.
 */
public function rules()
{
    return [
        'url'      => 'required|url',
        'provider' => 'required|in:bitly,tiny', // Add here your new provider with your custom key
    ];
}
```

## Available shorter services

| Usable Shorter Provider Service | Provider Name | Api Verison |
|---------------------------------|---------------|-------------|
| TinyURL             | `tiny`        | 3.0.0       |
| Bit.ly                | `bitly`       | 4.0.0       |
