<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/05/17
 * Time: 18:19
 */

namespace Handlers;


use Symfony\Component\Filesystem\Filesystem;

class StubHandler
{
	protected $variables;

	protected $stub;
	protected $stubInfo;

	private $fileSystem;

	protected $defaultStubs = [
		'app'        => [
			'file'     => 'app/app.stub',
			'location' => 'app/',
			'name'     => 'app.stub',
			'title'    => 'app',
			'ext'      => '.js',
		],
		'bootstrap'  => [
			'file'     => 'app/bootstrap.stub',
			'location' => 'app/',
			'name'     => 'bootstrap.stub',
			'title'    => 'bootstrap',
			'ext'      => '.js',
		],
		'controller' => [
			'file'     => 'app/controller.stub',
			'location' => 'app/controllers/',
			'name'     => 'controller.stub',
			'title'    => 'controller',
			'ext'      => '.js',
		],
		'service'    => [
			'file'     => 'app/service.stub',
			'location' => 'app/services/',
			'name'     => 'service.stub',
			'title'    => 'service',
			'ext'      => '.js',
		],
	];


	public function __construct()
	{
		$this->fileSystem = new Filesystem();

		$this->loadDefaultVariables();
	}

	public function saveStub()
	{
		$fileSystem = new Filesystem();
		$fileSystem->mkdir($this->stubInfo['location']);

		file_put_contents(__DIR__ . '/../' . $this->stubInfo['location'] . $this->stubInfo['title'] . $this->stubInfo['ext'], $this->stub);

		return $this;

	}

	public function loadDefaultVariables()
	{
		$variables       = json_decode(file_get_contents(__DIR__ . '/../default_variables.json'), true);
		$this->variables = $variables;
	}

	public function createStub($stub, $variables = [], $title = null, $location = null)
	{
		$this->setStub($stub, $title, $location);
		$stubVariables = array_merge($this->variables, $variables);

		foreach ($stubVariables as $key => $value) {
			$this->stub = str_replace('{{' . $key . '}}', $value, $this->stub);
		}

		$this->saveStub();

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVariables()
	{
		return $this->variables;
	}

	/**
	 * @return mixed
	 */
	public function getStub()
	{
		return $this->stub;
	}

	/**
	 * @param mixed  $stub | Stub file name
	 *
	 * @param string $title
	 * @param string $location
	 *
	 * @return StubHandler
	 * @throws \Exception
	 */
	public function setStub($stub, $title = null, $location = null)
	{
		if (!in_array($stub, array_keys($this->defaultStubs))) {
			throw new \Exception('Cannot find stub type.');
		}

		$stubDetails = $this->defaultStubs[$stub];
		if ($title !== null) {
			$stubDetails['title'] = $title;
		}
		if ($location !== null) {
			$stubDetails['location'] = $location;
		}

		$this->stub     = file_get_contents(__DIR__ . '/../stubs/' . $stubDetails['location'] . $stubDetails['name']);
		$this->stubInfo = $stubDetails;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStubInfo()
	{
		return $this->stubInfo;
	}


}