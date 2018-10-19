<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractApiControllerTest
 * @package ApiBundle\Tests\Controller
 */
abstract class AbstractApiControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    /**
     * AbstractApiControllerTest constructor.
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->initClient();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->initClient();
        }
        return $this->client;
    }

    /**
     * Init basic http client
     */
    private function initClient()
    {
        $this->client = static::createClient();
        // follow redirects because `/url != /url/`
        $this->client->followRedirects();
    }
}
