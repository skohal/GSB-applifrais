<?php

namespace FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FraisForfaitControllerControllerTest extends WebTestCase
{
    public function testEditfraisforfait()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editFraisForfait');
    }

}
