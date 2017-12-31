<?php

namespace FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DataDefaultControllerTest extends WebTestCase
{
    public function testCreatdata()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/creatData');
    }

}
