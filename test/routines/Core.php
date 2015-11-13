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
			needs($data['root'] . '/test/shims/EnvironmentException.php');
			needs($data['root'] . '/test/shims/ShimEngine.php');

			@mkdir($data['root'] . '/test/sample/root/writable/unwritable', 0500);
		},

		'cleanup' => function($data, $shared) {
			@rmdir($data['root'] . '/test/sample/root/writable/test');
			@rmdir($data['root'] . '/test/sample/root/writable/unwritable');
		},

		'tests' => [

			/**
			 *
			 */
			'New Application' => function($data, $shared)
			{
				putenv('efoo1=test1');

				$_SERVER['efoo2']    = 'test2';
				$shared->application = new Inkwell\Core($data['root'] . '/test/sample/root');
			},


			/**
			 *
			 */
			'Environment Checks' => function($data, $shared)
			{
				assert('Inkwell\Core::checkSAPI')
					-> using($shared->application)
					-> with('cli')
					-> is(TRUE)

					-> with('apache')
					-> is(FALSE)
				;

				assert('Inkwell\Core::getEnvironment')
					-> using($shared->application)
					-> with('efoo1')
					-> is('test1')

					-> with('efoo2')
					-> is('test2')

					-> with('efoo3')
					-> is(NULL)

					-> with('efoo3', 'default')
					-> is('default')
				;
			},

			/**
			 *
			 */
			'Container Functions' => function($data, $shared)
			{
				assert('Inkwell\Core::offsetSet')
					-> using($shared->application)
					-> with('foo', 'bar')
					-> is(NULL)
				;

				assert('Inkwell\Core::offsetExists')
					-> using($shared->application)
					-> with('foo')
					-> is(TRUE);
				;

				assert('Inkwell\Core::offsetGet')
					-> using($shared->application)
					-> with('foo', 'bar')
					-> is('bar')
				;

				assert('Inkwell\Core::offsetUnset')
					-> using($shared->application)
					-> with('foo')
					-> is(NULL)
				;

				assert('Inkwell\Core::offsetGet')
					-> using($shared->application)
					-> with('foo', 'bar')
					-> throws('Dotink\Flourish\ProgrammerException')
				;

				assert('Inkwell\Core::offsetExists')
					-> using($shared->application)
					-> with('foo')
					-> is(FALSE);
				;
			},


			/**
			 *
			 */
			'Get Directory' => function($data, $shared)
			{
				assert('Inkwell\Core::getDirectory')
				 	-> using($shared->application)
					-> is($data['root'] . '/test/sample/root')

					-> with('writable')
					-> is($data['root'] . '/test/sample/root/writable')

					-> with('non-existent-directory')
					-> throws('Dotink\Flourish\EnvironmentException')
				;
			},


			/**
			 *
			 */
			'Writable Directory' => function($data, $shared)
			{
				assert('Inkwell\Core::setWriteDirectory')
				 	-> using($shared->application)
					-> with('bad-writable')
					-> throws('Dotink\Flourish\EnvironmentException')
				;

				assert('Inkwell\Core::setWriteDirectory')
				 	-> using($shared->application)
					-> with('writable/unwritable')
					-> throws('Dotink\Flourish\EnvironmentException')
				;

				assert('Inkwell\Core::setWriteDirectory')
				 	-> using($shared->application)
					-> with('writable')
					-> is(NULL)
				;

				assert('Inkwell\Core::getWriteDirectory')
					-> using($shared->application)
					-> is($data['root'] . '/test/sample/root/writable')

					-> with('test')
					-> is($data['root'] . '/test/sample/root/writable/test')
				;

				assert('Inkwell\Core::getWriteDirectory')
					-> using($shared->application)
					-> with('unwritable/test')
					-> throws('Dotink\Flourish\EnvironmentException')
				;

				assert('Inkwell\Core::setWriteDirectory')
				 	-> using($shared->application)
					-> with('writable/test')
					-> is(NULL)
				;

				rmdir($data['root'] . '/test/sample/root/writable/test');
				mkdir($data['root'] . '/test/sample/root/writable/test', 0000);

				assert('Inkwell\Core::getWriteDirectory')
					-> using($shared->application)
					-> with('no-longer-writable-directory')
					-> throws('Dotink\Flourish\EnvironmentException')
				;
			},

			/**
			 *
			 */
			'Execution Mode Setting/Getting' => function($data, $shared)
			{
				assert('Inkwell\Core::setExecutionMode')
					-> using($shared->application)
					-> with('bad-execution-mode')
					-> throws('Dotink\Flourish\ProgrammerException')

					-> with('production')
					-> is(NULL)
				;

				assert('Inkwell\Core::getExecutionMode')
					-> using($shared->application)
					-> is('production')
				;

				assert('Inkwell\Core::checkExecutionMode')
					-> using($shared->application)
					-> with('development')
					-> is(FALSE)

					-> with('production')
					-> is(TRUE)
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

				//
				// Passing no callback, with no registered handler should throw an exception
				//

				assert('Inkwell\Core::run')
					-> using($shared->application)
					-> with(NULL)
					-> throws('Dotink\Flourish\ProgrammerException')
				;

				//
				// Passing a callback directly should return the value
				//

				assert('Inkwell\Core::run')
					-> using($shared->application)
					-> with(function() { return 'callback'; })
					-> is('callback')
				;

				//
				// Setting an engine handler
				//

				$shared->application['engine.handler'] = function() {
					return 'handler';
				};

				//
				// Passing a callback directly should STILL return the callback value
				//

				assert('Inkwell\Core::run')
					-> using($shared->application)
					-> with(function() { return 'callback'; })
					-> is('callback')
				;

				//
				// Passing no callback should now hit the registered handler
				//

				assert('Inkwell\Core::run')
					-> using($shared->application)
					-> is('handler')
				;
			}
		]
	];
}
