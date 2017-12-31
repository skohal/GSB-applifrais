<?php

namespace FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FraisControllerTest extends WebTestCase
{
    public function testAddfrais()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addFrais');
    }

}
