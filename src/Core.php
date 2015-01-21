<?php namespace Inkwell
{
	use ArrayAccess;
	use Dotink\Flourish;
	use IW;

	class Core implements ArrayAccess
	{
		private $executionMode  = NULL;
		private $rootDirectory  = NULL;
		private $writeDirectory = NULL;

		/**
		 *
		 */
		public function __construct($root_directory)
		{
			$this->rootDirectory = $root_directory;
		}


		/**
		 *
		 */
		public function checkExecutionMode($mode)
		{
			return $mode == $this->getExecutionMode();
		}


		/**
		 *
		 */
		public function getDirectory($sub_directory = NULL)
		{
			if ($sub_directory) {
				$sub_directory = str_replace('/', IW\DS, $sub_directory);
				$directory     = !preg_match(IW\REGEX\ABSOLUTE_PATH, $sub_directory)
					? $this->getDirectory() . IW\DS . $sub_directory
					: $sub_directory;

			} else {
				$directory = $this->rootDirectory;
			}

			if (!is_dir($directory)) {
				throw new Flourish\ProgrammerException(
					'Could not access directory "%s"',
					$directory
				);
			}

			return rtrim($directory, '/\\' . IW\DS);
		}


		/**
		 *
		 */
		public function getEnvironment($key, $default = NULL)
		{
			$value = isset($_SERVER[$key])
				? $_SERVER[$key]
				: getenv($key);

			return $value ?: $default;
		}


		/**
		 *
		 */
		public function getExecutionMode()
		{
			return $this->executionMode;
		}


		/**
		 *
		 */
		public function getWriteDirectory($sub_directory = NULL)
		{
			if ($sub_directory) {
				$sub_directory   = str_replace('/', IW\DS, $sub_directory);
				$write_directory = !preg_match(IW\REGEX\ABSOLUTE_PATH, $sub_directory)
					? $this->getWriteDirectory() . IW\DS . $sub_directory
					: $sub_directory;

			} else {
				$write_directory = $this->writeDirectory;
			}

			if (!is_dir($write_directory) && !@mkdir($write_directory, 0777, TRUE)) {
				throw new Flourish\EnvironmentException(
					'Unable to resolve write directory %s',
					$write_directory
				);
			}

			return rtrim($write_directory, '/\\' . IW\DS);
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
		 *
		 */
		public function run($callback)
		{
			$this['engine']->exec($callback);
		}


		/**
		 *
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
		 *
		 */
		public function setWriteDirectory($directory)
		{
			$write_directory = $this->getDirectory($directory);

			if (!is_dir($write_directory) || !is_writable($write_directory)) {
				throw new Flourish\EnvironmentException(
					'Cannot set writable directory %s, not a directory or not writable',
					$write_directory
				);
			}

			$this->writeDirectory = $write_directory;
		}
	}
}
