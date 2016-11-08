<?php

namespace UserBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Commande de test de generation de code
 * Class ControllerGeneratorCommand
 * @package UserBundle\Command
 */
class ControllerGeneratorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('controller:generate')
            ->setDefinition(
                [
                    new InputOption('controller', '', InputOption::VALUE_REQUIRED, 'Le nom du controller a creer'),
                    new InputOption('bundle', '', InputOption::VALUE_REQUIRED, 'Le bundle dans lequel creer le controlleur'),
                    new InputOption('basecontroller', '', InputOption::VALUE_REQUIRED, 'S\'il faut ou non heriter du controlleur de base de Symfony2'),
                ]
            )
            ->setDescription('Genere le code de base pour commencer a utiliser un controlleur')
            ->setHelp('Cette commande vous permet de facilement generer le code necessaire pour commencer a travailler avec un controlleur. N\'hesitez pas a vous en servir quand vous avez besoin d\'en creer un !');
    }

    

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        
        // On recupere les options
        $controller     = $input->getOption('controller');
        $basecontroller = $input->getOption('basecontroller');
        $bundleName     = $input->getOption('bundle');
        
        

        // On recupere les infos sur le bundle nécessaire à la génération du controller
        $kernel    = $this->getContainer()->get('kernel');
        $bundle    = $kernel->getBundle($bundleName);
        $namespace = $bundle->getNamespace();
        $path      = $bundle->getPath();
        $target    = $path . '/Controller/' . $controller . 'Controller.php';
        $target_twig = $path . '/Resources/views/' . $bundleName . '/index.html.twig';

        // On génère le contenu du controlleur
        $twig = $this->getContainer()->get('templating');

        $controller_code = $twig->render('UserBundle:ControllerBundle:Controller.php.twig',
            array(
                'controller' => $controller,
                'basecontroller' => $basecontroller,
                'namespace' => $namespace
            )
        );
        
        $temlate_code  = $twig->render('UserBundle:ControllerBundle:index.html.twig.twig', ['bundle'=> $bundleName]);

        dump($target);
        dump($target_twig);
        // On crée le fichier
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }
    
        if (!is_dir(dirname($target_twig))) {
            mkdir(dirname($target_twig), 0777, true);
        }
        file_put_contents($target, $controller_code);
        file_put_contents($target_twig, $temlate_code);

        return 0;
    }
}
