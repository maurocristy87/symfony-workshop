<?php

namespace App\Command;

use Domain\Exception\ServiceRuntimeException;
use Domain\Service\Product\UpdateProductsBitcoinServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateProductBtcCommand extends Command
{
    protected static $defaultName = 'app:update-product-btc';
    
    private UpdateProductsBitcoinServiceInterface $service;
    
    public function __construct(UpdateProductsBitcoinServiceInterface $service)
    {
        parent::__construct();
        
        $this->service = $service;
    }

    protected function configure()
    {
        $this->setDescription('Update products bitcoin price');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        try {
            $this->service->update();
            
            $io->success('Products updated!');
            return Command::SUCCESS;
        } catch (ServiceRuntimeException $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
