<?php

namespace App\Command;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class FetchFruitsCommand extends Command
{
    private $httpClient;
    private $entityManager;
    private $mailer;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('fetch:fruits')
            ->setDescription('Fetches fruits from Fruityvice API and saves them to the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');
        $fruits = $response->toArray();

        foreach ($fruits as $fruitData) {
            $fruit = new Fruit();
            $fruit->setName($fruitData['name']);
            $fruit->setFamily($fruitData['family']);
            $fruit->setNutritions($fruitData['nutritions']);


            $this->entityManager->persist($fruit);
        }

        $this->entityManager->flush();

        $output->writeln(sprintf('Saved %d fruits to the database', count($fruits)));

        // Send email when all fruits have been saved to the database
        $email = (new Email())
            ->from($_ENV['MAILER_FROM'])
            ->to('admin@example.com')
            ->subject('Fruits imported successfully')
            ->text('All fruits have been imported successfully.');

        $this->mailer->send($email);

        return Command::SUCCESS;
    }
}
