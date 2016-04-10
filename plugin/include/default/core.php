<?php

	return Affinity\Action::create(function($app, $broker) {

		//
		// Setup execution mode and debugging
		//

		$server_admin = $app->getEnvironment('SERVER_ADMIN', 'root');

		$app->setExecutionMode($this->fetch('core', 'execution_mode', IW\EXEC_MODE\PRODUCTION));
		$app->setWriteDirectory($this->fetch('core', 'write_directory', 'writable'));

		//
		// Setup some standard PHP requirements
		//

		$default_timezone = $this->fetch('core', 'timezone', 'GMT');
		$session_path     = $this->fetch('core', 'session.path', sys_get_temp_dir());
		$session_name     = $this->fetch('core', 'session.name', 'IWSESSID');

		date_default_timezone_set($default_timezone);
		session_save_path($app->getDirectory($session_path));
		session_name($session_name);

		if (session_status() == PHP_SESSION_NONE) {
			session_start();

			if (!isset($_SESSION['IWSESSINIT'])) {
				$_SESSION['IWSESSINIT'] = TRUE;

				session_regenerate_id();
			}
		}

		foreach ($this->fetch('@providers') as $id) {
			$provider_mapping = $this->fetch($id, '@providers.mapping', []);
			$provider_params  = $this->fetch($id, '@providers.params',  []);

			foreach ($provider_mapping as $interface => $provider) {
				if ($provider instanceof \Closure) {
					$broker->delegate($interface, $provider);
				} else {
					$broker->alias($interface, $provider);
				}
			}

			foreach ($provider_params as $provider => $params) {
				$broker->define($provider, $params);
			}
		}

		//
		// Make our container a shared instance for itself so we maintain all of the above
		//

		$broker->share($broker);
	});
