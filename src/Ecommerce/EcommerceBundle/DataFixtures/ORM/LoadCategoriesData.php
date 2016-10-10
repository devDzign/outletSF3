<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 06/10/2016
 * Time: 11:19
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Categories;

/**
 * Class LoadCategoriesData
 * @package Ecommerce\EcommerceBundle\DataFixtures\ORM
 */
class LoadCategoriesData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categorie1 = new Categories();
        $categorie1->setNom('Légumes');
        $categorie1->setImage($this->getReference('media1'));
        $manager->persist($categorie1);
        
        $categorie2 = new Categories();
        $categorie2->setNom('fruits');
        $categorie2->setImage($this->getReference('media2'));
        $manager->persist($categorie2);
        
        $manager->flush();

        $this->addReference('categorie1', $categorie1);
        $this->addReference('categorie2', $categorie2);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}