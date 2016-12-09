<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 01/12/2016
 * Time: 09:53
 */

namespace Ecommerce\EcommerceBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FacturesCommand extends ContainerAwareCommand
{
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        
        $date = new \DateTime();
        $em       = $this->getContainer()->get('doctrine.orm.entity_manager');
        $factures = $em->getRepository('EcommerceBundle:Commandes')->byDateCommand($input->getArgument('date'));
    
        $output->writeln(count($factures) . ' facture(s).');
        $path = $this->getContainer()->getParameter('kernel.root_dir') . '/../web/';
    
       

        if (count($factures) > 0) {
            $dir  = $date->format('d-m-Y_h-i-s');
            $path = $path . 'Facturations/' . $dir;
            mkdir($path);
         
            foreach ($factures as $facture) {
                $this->getContainer()->get('generate_facture_to_pdf_service')->generateFactureCommand($facture)
                    ->Output($path . '/facture-' . $facture->getReference() . '.pdf', 'F');

            }
            
        }
        
    }
    
    protected function configure()
    {
        $this
            ->setName('ecommerce:facture')
            ->setDescription('Ceci est test')
            ->addArgument('date', InputArgument::OPTIONAL, 'Date pour laquel vous souhaitez récuperer les factures')
            ->setHelp("This command allows you to create factures...");
    }
    
}