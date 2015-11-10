<?php namespace Dotink\Flourish
{
	class ProgrammerException extends \Exception
	{
		public function __construct($message)
		{
			return vsprintf($message, array_slice(func_get_args(), 1));
		}
	}
}
