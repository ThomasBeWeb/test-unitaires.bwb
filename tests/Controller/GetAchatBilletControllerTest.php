<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetAchatBilletControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getbillet');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prix")')->count()
        );
    }
}