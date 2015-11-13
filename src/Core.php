<?php namespace Inkwell
{
	use ArrayAccess;
	use Dotink\Flourish;

	/**
	 * The inKWell application core.
	 *
	 * The application core acts as a container with some basic helper methods to maintain and
	 * the state of the application.
	 */
	class Core implements ArrayAccess
	{
		const DS = DIRECTORY_SEPARATOR;
		const REGEX_ABSOLUTE_PATH = '#^(/|\\\\|[a-z]:(\\\\|/)|\\\\|//)#i';

		/**
		 * The container context
		 *
		 * @access private
		 * @var array
		 */
		private $context = array();

		/**
		 * The execution mode for the application
		 *
		 * @access private
		 * @var string
		 */
		private $executionMode  = NULL;

		/**
		 * The root directory for the application
		 *
		 * @access private
		 * @var string
		 */
		private $rootDirectory  = NULL;

		/**
		 * The writable directory for the application
		 *
		 * @access private
		 * @var string
		 */
		private $writeDirectory = NULL;


		/**
		 * Instantiate a new application at a given root directory
		 *
		 * @access public
		 * @param string $root_directory The root directory for the new application instance
		 * @return void
		 */
		public function __construct($root_directory)
		{
			$this->rootDirectory = $root_directory;
		}


		/**
		 * Check the current execution mode
		 *
		 * @access public
		 * @param string $mode The mode for which we wish to check
		 * @return boolean TRUE if the current execution mode matches `$mode`, FALSE otherwise
		 */
		public function checkExecutionMode($mode)
		{
			return $mode == $this->getExecutionMode();
		}


		/**
		 * Check the current SAPI provider
		 *
		 * @access public
		 * @param string|array $sapi The SAPI name(s) for which we wish to check
		 * @return boolean TRUE if the current SAPI provider matches `$sapi`, FALSE otherwise
		 */
		public function checkSAPI($sapi)
		{
			settype($sapi, 'array');

			return in_array(PHP_SAPI, $sapi);
		}


		/**
		 * Get the application root directory or an absolute path to a relative sub directory
		 *
		 * @access public
		 * @param string $sub_directory A relative sub-directory for which to get an absolute path
		 * @return string The absolute path to the application root or sub directory within it
		 * @throws Flourish\EnvironmentException If the path is not a directory
		 */
		public function getDirectory($sub_directory = NULL)
		{
			if ($sub_directory) {
				$sub_directory = str_replace('/', self::DS, $sub_directory);
				$directory     = !preg_match(self::REGEX_ABSOLUTE_PATH, $sub_directory)
					? $this->getDirectory() . self::DS . $sub_directory
					: $sub_directory;

			} else {
				$directory = $this->rootDirectory;
			}

			if (!is_dir($directory)) {
				throw new Flourish\EnvironmentException(
					'Could not access "%s", not a directory',
					$directory
				);
			}

			return rtrim($directory, '/\\' . self::DS);
		}


		/**
		 * Get an environment variable from the server or execution context
		 *
		 * @access public
		 * @param string $key The key from which to retrieve the environment variable
		 * @param mixed $default The default value if the `$key` is not found in the environment
		 * @return mixed The environment variable value or the `$default` if it does not exist
		 */
		public function getEnvironment($key, $default = NULL)
		{
			$value = isset($_SERVER[$key])
				? $_SERVER[$key]
				: getenv($key);

			return $value ?: $default;
		}


		/**
		 * Get the current execution mode
		 *
		 * @access public
		 * @return string The current execution mode
		 */
		public function getExecutionMode()
		{
			return $this->executionMode;
		}


		/**
		 * Get the application write directory or an absolute path to a relative sub directory
		 *
		 * This method will attempt to create a writable directory if it the specified directory
		 * or sub-directory does not exist.
		 *
		 * @access public
		 * @param string $sub_directory A relative sub-directory for which to get an absolute path
		 * @param integer $mode The mode (permissions) with which to create a directory
		 * @return string The absolute path to the application write directory or sub directory within it
		 * @throws Flourish\EnvironmentException If the path is not writable/creatable
		 */
		public function getWriteDirectory($sub_directory = NULL, $mode = 0770)
		{
			if ($sub_directory) {
				$sub_directory   = str_replace('/', self::DS, $sub_directory);
				$write_directory = !preg_match(self::REGEX_ABSOLUTE_PATH, $sub_directory)
					? $this->getWriteDirectory() . self::DS . $sub_directory
					: $sub_directory;

			} else {
				$write_directory = $this->writeDirectory;
			}

			if (!is_dir($write_directory)) {
				if (!@mkdir($write_directory, $mode, TRUE)) {
					throw new Flourish\EnvironmentException(
						'Unable to resolve write directory %s, does not exist',
						$write_directory
					);
				}

			} elseif (!is_writable($write_directory)) {
				throw new Flourish\EnvironmentException(
					'Unable to resolve write directory %s, not writable',
					$write_directory
				);
			}

			return rtrim($write_directory, '/\\' . self::DS);
		}


		/**
		 * Sets a context element via array access (NOT ALLOWED)
		 *
		 * @access public
		 * @param mixed $offset The context element offset to set
		 * @param mixed $value The value to set for the offset
		 * @return void
		 */
		public function offsetSet($offset, $value)
		{
			$this->context[$offset] = $value;
		}


		/**
		 * Checks whether or not a context element exists
		 *
		 * @access public
		 * @param mixed $offset The context element offset to check for existence
		 * @return boolean TRUE if the context exists, FALSE otherwise
		 */
		public function offsetExists($offset)
		{
			return array_key_exists($offset, $this->context);
		}


		/**
		 * Attempts to unset a context element
		 *
		 * @access public
		 * @param mixed $offset The context element offset to unset
		 * @return void
		 */
		public function offsetUnset($offset)
		{
			if ($this->offsetExists($offset)) {
				unset($this->context[$offset]);
			}
		}


		/**
		 * Gets a context element
		 *
		 * @access public
		 * @param mixed $offset The context element offset to get
		 * @return mixed The value of the offset
		 */
		public function offsetGet($offset)
		{
			if (!$this->offsetExists($offset)) {
				throw new Flourish\ProgrammerException(
					'Provider "%s" not set on parent %s',
					$offset,
					__CLASS__
				);
			}

			return $this->context[$offset];
		}


		/**
		 * Run the application
		 *
		 * If a callback is provided the callback will be passed to the registered engine for
		 * execution, otherwise if the application contains an `engine.handler`, it will be passed
		 * to the engine for execution.
		 *
		 * @access public
		 * @param callable $callback The callback which the engine should execute
		 * @return mixed The return result from the execution of the callback
		 * @throws Flourish\ProgrammerException if no engine is registered in the app container
		 * @throws Flourish\ProgrammerException if no handler is registered in the app container
		 */
		public function run(callable $callback = NULL)
		{
			if (!$this->offsetExists('engine')) {
				throw new Flourish\ProgrammerException(
					'No engine was provided with which to execute the application'
				);
			}

			return $this['engine']->exec($callback ?: $this['engine.handler']);
		}


		/**
		 * Set the current execution mode
		 *
		 * Valid execution modes include 'development' or 'production'.
		 *
		 * @access public
		 * @param string $mode The current execution mode
		 * @return void
		 * @throws Flourish\ProgrammerException If the provided `$mode` is not valid
		 */
		public function setExecutionMode($mode)
		{
			$valid_execution_modes = ['development', 'production'];

			if (!in_array($mode, $valid_execution_modes)) {
				throw new Flourish\ProgrammerException(
					'Invalid execution mode %s specified',
					$mode
				);
			}

			$this->executionMode = $mode;
		}


		/**
		 * Set the write directory as an absolute path or sub-diretory of the application root
		 *
		 * @access public
		 * @param string $directory The write directory for the application
		 * @return void
		 * @throws Flourish\ProgrammerException If the `$directory` is not a directory or writable
		 */
		public function setWriteDirectory($directory)
		{
			$write_directory = $this->getDirectory($directory);

			if (!is_writable($write_directory)) {
				throw new Flourish\EnvironmentException(
					'Cannot set writable directory %s, directory is not writable',
					$write_directory
				);
			}

			$this->writeDirectory = $write_directory;
		}
	}
}
