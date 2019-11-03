<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MakeAdminCommand extends Command
{
    protected static $defaultName = 'make:admin';
    private $passwordEncoder;
    private $container;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ContainerInterface $container, string $name = null)
    {
        parent::__construct($name);
        $this->passwordEncoder = $passwordEncoder;
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Permet de crér un nouvel utilisateur avec le role ADMIN')
            ->addArgument('email', InputArgument::OPTIONAL, 'Adresse e-mail')
            ->addArgument('password', InputArgument::OPTIONAL, 'Mot de passe')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        if (!$email) {
            $io->error('You need to pass an email argument');
        }
        if (!$password) {
            $io->error('You need to pass a password argument');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setRoles(['ROLE_ADMIN']);
        $manager = $this->container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        $io->success("You have created the user {$user->getEmail()}.");
    }
}
