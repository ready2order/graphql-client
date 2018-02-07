<?php

namespace Softonic\GraphQL;

use League\OAuth2\Client\Provider\AbstractProvider as OAuth2Provider;
use Psr\Cache\CacheItemPoolInterface as Cache;

class ClientBuilder
{
	/**
	 * @param string $endpoint
	 * @param array $guzzleOptions
	 * @return Client
	 */
	public static function build(string $endpoint, array $guzzleOptions = []) : Client
	{
		// allow custom guzzle options
		$guzzleOptions = array_merge(['base_uri' => $endpoint], $guzzleOptions);

		return new \Softonic\GraphQL\Client(
			new \GuzzleHttp\Client($guzzleOptions),
			new \Softonic\GraphQL\ResponseBuilder()
		);
	}

	/**
	 * @param string $endpoint
	 * @param OAuth2Provider $oauthProvider
	 * @param array $tokenOptions
	 * @param Cache $cache
	 * @param array $guzzleOptions
	 * @return Client
	 */
    public static function buildWithOAuth2Provider(
        string $endpoint,
        OAuth2Provider $oauthProvider,
        array $tokenOptions,
        Cache $cache,
	    array $guzzleOptions = []
    ): Client {
		// allow custom guzzle options
	    $guzzleOptions = array_merge(['base_uri' => $endpoint], $guzzleOptions);


        return new \Softonic\GraphQL\Client(
            \Softonic\OAuth2\Guzzle\Middleware\ClientBuilder::build(
                $oauthProvider,
                $tokenOptions,
                $cache,
                $guzzleOptions
            ),
            new \Softonic\GraphQL\ResponseBuilder()
        );
    }
}
