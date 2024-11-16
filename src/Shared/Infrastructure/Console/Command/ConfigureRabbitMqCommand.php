<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Console\Command;

use App\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Traversable;

final class ConfigureRabbitMqCommand extends Command
{
    protected static string $defaultName = 'app:domain-events:rabbitmq:configure';

    public function __construct(
        private readonly RabbitMqConfigurer $configurer,
        private readonly string $exchangeName,
        private readonly Traversable $subscribers
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Configure the RabbitMQ to allow publish & consume domain events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Configuring RabbitMQ...');
        $output->writeln('Configuring Exchange ' . $this->exchangeName . '...');
        $output->writeln('Found ' . iterator_count($this->subscribers) . ' subscribers to configure...');
        foreach ($this->subscribers as $subscriber) {
            $output->writeln(' - ' . get_class($subscriber));
        }

        $this->configurer->configure($output, $this->exchangeName, ...iterator_to_array($this->subscribers));

        $output->writeln('RabbitMQ configured!');

        return 0;
    }
}
