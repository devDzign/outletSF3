<?php

namespace Ecommerce\EcommerceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitsControllerTest extends WebTestCase
{
    public function testProduits()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/produits');

        $this->assertContains('Ajouter au panier', $client->getResponse()->getContent());
    }

    public function testProduits2()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/produits');

        $this->assertEquals(
            0,
            $crawler->filter('html:contains("Hello World")')->count()
        );
    }
}
