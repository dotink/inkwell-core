<?php namespace Dotink\Lab
{
	use Inkwell;

	return [
		/**
		 *
		 */
		'setup' => function($data, $shared) {
			needs($data['root'] . '/src/Core.php');
			needs($data['root'] . '/src/EngineInterface.php');
			needs($data['root'] . '/test/shims/ProgrammerException.php');
			needs($data['root'] . '/test/shims/ShimEngine.php');
		},

		'tests' => [

			/**
			 *
			 */
			'New Application' => function($data, $shared)
			{
				$shared->application = new Inkwell\Core($data['root'] . '/test/sample/root');
			},

			/**
			 *
			 */
			'Get Directory' => function($data, $shared)
			{
				assert('Inkwell\Core::getDirectory')
				 	-> using($shared->application)
					-> with('writable')
					-> is($data['root'] . '/test/sample/root/writable')
				;
			},

			/**
			 *
			 */
			'Set Write Directory' => function($data, $shared)
			{
				assert('Inkwell\Core::setWriteDirectory')
				 	-> using($shared->application)
					-> with('bad-writable')
					-> throws('Dotink\Flourish\ProgrammerException')

					-> with('writable')
					-> is(NULL)
				;
			},

			/**
			 *
			 */
			'Run' => function($data, $shared)
			{
				assert('Inkwell\Core::run')
					-> using($shared->application)
					-> with(function() {})
					-> throws('Dotink\Flourish\ProgrammerException')
				;

				$shared->application['engine'] = new Inkwell\ShimEngine();

				assert('Inkwell\Core::run')
					-> using($shared->application)
					-> with(function() {})
					-> is(TRUE)
				;
			}
		]
	];
}
