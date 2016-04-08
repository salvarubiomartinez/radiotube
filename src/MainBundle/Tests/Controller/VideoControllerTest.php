<?php

namespace MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VideoControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Create');
    }

    public function testDetails()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Details/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Delete/{id}');
    }

}
