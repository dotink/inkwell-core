<?php namespace Inkwell
{
	/**
	 * The engine interface.
	 *
	 * Any engine registered with the application container should implement this interface
	 * so that it can run the application.
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
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
