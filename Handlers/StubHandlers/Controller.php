<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/05/17
 * Time: 19:06
 */

namespace Handlers;


class Controller
{

	private $handler;

	public function __construct()
	{
		$this->handler = new StubHandler();
	}

	public function createController($name)
	{
		$stub = $this->handler->createStub('controller', [
			'controller_name' => $name,
		]);


	}

}