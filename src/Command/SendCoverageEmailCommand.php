<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendCoverageEmailCommand extends Command
{
    public function __construct(private MailerInterface $mailer)
    {
        parent::__construct();
    }

    protected static $defaultName = 'coverage:send-email';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (new Email())
            ->from('admin@admin.com')
            ->to('admin@admin.com')
            ->subject('Coverage result')
            ->text('See attachment')
            ->attachFromPath('tests/coverage.txt');

        $this->mailer->send($email);
        return Command::SUCCESS;
    }

}