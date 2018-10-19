<?php

namespace ApiBundle\Tests\Controller;

/**
 * Class DefaultControllerTest
 * @package ApiBundle\Tests\Controller
 */
class DefaultControllerTest extends AbstractApiControllerTest
{
    /**
     * @throws \Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/api/ping');

        $expected = json_encode(['message' => 'pong']);

        $responseBody = $client->getResponse()->getContent();
        $this->assertJson($responseBody);
        $this->assertJsonStringEqualsJsonString($responseBody, $expected);
    }
}
