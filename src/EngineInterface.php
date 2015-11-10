<?php namespace Inkwell
{
	/**
	 * The engine interface.
	 *
	 * Any engine registered with the application container should implement this interface
	 * so that it can run the application.
	 */
	interface EngineInterface
	{
		/**
		 * Execute a callback and return the result
		 *
		 * @access public
		 * @param callable $callback The callback to execute
		 * @return mixed The result of the callback
		 */
		public function exec(callable $callback);
	}
}
