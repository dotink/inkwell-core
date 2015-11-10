<?php namespace Inkwell
{
	use Affinity;

	/**
	 * A default engine based on Affinity
	 *
	 * This is only usable if Affinity is installed.
	 */
	class DefaultEngine extends Affinity\Engine implements EngineInterface
	{
	}
}
