<?php namespace Inkwell
{
	class ShimEngine implements EngineInterface
	{
		public function exec(callable $callback)
		{
			return TRUE;
		}
	}
}
