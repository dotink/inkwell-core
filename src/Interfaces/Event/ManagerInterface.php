<?php namespace Inkwell\Event
{
	Interface ManagerInterface extends EmitterInterface
	{
		/**
		 * Trigger an event to be emitted
		 *
		 * @param string $event The event to emit
		 * @param array $data Abitrary data to pass to listeners, should be documented with events
		 * @param EmitterInterface $context Additional emitter context which can handle follow up events
		 * @return void
		 */
		public function trigger($event, Array $data, EmitterInterface $context = NULL);


		/**
		 * Watch another emitter for triggered events
		 *
		 * @param EmitterInterface $emitter The emitter to watch
		 * @return void
		 */
		public function watch(EmitterInterface $emitter);
	}
}