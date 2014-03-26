<?php namespace Inkwell\Event
{
	Interface EmitterInterface
	{
		/**
		 * Register a listener for a given event
		 *
		 * @param string $event The event to listen for
		 * @param Callable $callback The callback to call when the event is emitted
		 * @return void
		 */
		public function on($event, Callable $callback);
	}
}