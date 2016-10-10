<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 06/10/2016
 * Time: 11:19
 */

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use UserBundle\Entity\User;

/**
 * Class LoadUserData
 * @package UserBundle\DataFixtures\ORM
 */
class LoadUserData  extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new User();
        $utilisateur1->setUsername('client');
        $utilisateur1->setEmail('client@client.com');
        $utilisateur1->setEnabled(1);
        
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur1, 'client');
        $utilisateur1->setPassword($password);

        $manager->persist($utilisateur1);

        $utilisateur2 = new User();
        $utilisateur2->setUsername('client2');
        $utilisateur2->setEmail('client2@client.com');
        $utilisateur2->setEnabled(1);
        
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur2, 'client2');
        $utilisateur2->setPassword($password);

        $manager->persist($utilisateur2);

        $utilisateur3 = new User();
        $utilisateur3->setUsername('client3');
        $utilisateur3->setEmail('client3@client.com');
        $utilisateur3->setEnabled(1);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur3, 'client3');
        $utilisateur3->setPassword($password);

        $manager->persist($utilisateur3);


        $utilisateur4 = new User();
        $utilisateur4->setUsername('admin');
        $utilisateur4->setEmail('admin@admin.com');
        $utilisateur4->setEnabled(1);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur4, 'admin');
        $utilisateur4->setPassword($password);

        $manager->persist($utilisateur4);

        $utilisateur5 = new User();
        $utilisateur5->setUsername('admin2');
        $utilisateur5->setEmail('admin2@admin.com');
        $utilisateur5->setEnabled(1);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($utilisateur5, 'admin2');
        $utilisateur5->setPassword($password);

        $manager->persist($utilisateur5);

        $manager->flush();

        $this->addReference('utilisateur1', $utilisateur1);
        $this->addReference('utilisateur2', $utilisateur2);
        $this->addReference('utilisateur3', $utilisateur3);
        $this->addReference('utilisateur4', $utilisateur4);
        $this->addReference('utilisateur5', $utilisateur5);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}