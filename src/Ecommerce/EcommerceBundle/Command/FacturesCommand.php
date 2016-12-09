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
        
        if (count($factures) > 0) {
            $dir = $date->format('d-m-Y h-i-s');
            mkdir('Facturation/' . $dir);
            
            foreach ($factures as $facture) {
                $this->getContainer()->get('generate_facture_to_pdf_service')->generateFactureHtmlToPdf($facture->getId(), 'factures', $facture)
                    ->Ou('facturation/' . $dir . '/facture' . $facture->getReference() . '.pdf', 'F');
            }
            
            
            // retrieve the argument value using getArgument()
            $output->writeln('Username: ' . $input->getArgument('username'));
        }
        
    }
    
    protected function configure()
    {
        $this
            ->setName('ecommerce:facture')
            ->setDescription('Creates new users.')
            ->addArgument('data', InputArgument::REQUIRED, 'Date pour laquel vous souhaitez récuperer les factures')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to create users...");
    }