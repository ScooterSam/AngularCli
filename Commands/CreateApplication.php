<?php
namespace Commands;

use Handlers\StubHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateApplication extends Command
{
	protected $commandName = 'create';
	protected $commandDescription = "Creates the new application";

	protected $commandArgumentName = "name";
	protected $commandArgumentDescription = "Application name?";

	protected $commandOptionName = "cap"; // should be specified like "app:greet John --cap"
	protected $commandOptionDescription = 'If set, it will greet in uppercase letters';

	protected function configure()
	{
		$this
			->setName($this->commandName)
			->setDescription($this->commandDescription)
			->addArgument(
				$this->commandArgumentName,
				InputArgument::OPTIONAL,
				$this->commandArgumentDescription
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name    = $input->getArgument($this->commandArgumentName);
		$handler = new StubHandler();

		$stubs = [];

		$handler->createStub('bootstrap');
		$handler->createStub('app', ['app_name' => $name]);

		$handler->createStub('controller', ['name' => 'TestController'], 'TestController');
		$handler->createStub('service', ['name' => 'TestService'], 'TestService');

		$output->writeln('Successfully created app.');
	}
}