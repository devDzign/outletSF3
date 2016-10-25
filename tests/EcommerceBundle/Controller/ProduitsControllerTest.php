<?php

namespace Ecommerce\EcommerceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitsControllerTest extends WebTestCase
{
    public function testProduits()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/produits');
    
        $this->assertContains('Ajouter', $client->getResponse()->getContent(), 'message erreur');
    }

    public function testProduits2()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/produits');
    
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("All")')->count(),
            'mesage erreuur 2'
        );
    }
}
