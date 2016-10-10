<?php

namespace UserBundle\Command;


use Sensio\Bundle\GeneratorBundle\Manipulator\ConfigurationManipulator;
use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class ServiceGeneratorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('service:gen')
            ->setDefinition(
                [
                    new InputOption('service', '', InputOption::VALUE_REQUIRED, 'Le nom du controller a creer'),
                    new InputOption('bundle', '', InputOption::VALUE_REQUIRED, 'Le bundle dans lequel creer le controlleur'),
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
        $service    = $input->getOption('service');
        $bundleName = $input->getOption('bundle');
        
        // On recupere les infos sur le bundle nécessaire à la génération du controller
        $kernel    = $this->getContainer()->get('kernel');
        $bundle    = $kernel->getBundle($bundleName);
        $namespace = $bundle->getNamespace();
        $path      = $bundle->getPath();
        
        
        $targetRoutingPath = $path . '/Resources/config/services.yml';
        dump($targetRoutingPath);
        $currentContents = $currentContents = file_get_contents($targetRoutingPath);
        dump($currentContents);
        $test = strpos($currentContents, 'user:');
        dump($test);
        
        $newContents = substr($currentContents, 0, $targetLinebreakPosition) . "\n" . $code . substr($currentContents, $targetLinebreakPosition);
        
        if (false === file_put_contents($this->file, $newContents)) {
            return 0;
        }
        
        
    }
}
