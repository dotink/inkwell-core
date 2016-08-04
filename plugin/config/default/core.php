<?php

	return Affinity\Config::create([
		//
		// The system php command
		//

		'php' => 'php',

		//
		// The document root
		//

		'docroot' => 'public',

		//
		// The execution mode determines default operation for some processes which should
		// naturally differ depending on the environment (development vs. production)
		//

		'execution_mode'  => IW\EXEC_MODE\DEVELOPMENT,

		//
		// Timezone
		//

		'timezone' => 'America/Los_Angeles',

		//
		// Session settings
		//

		'session' => [
			'name' => 'IWSESSID',
			'path' => sys_get_temp_dir()
		],

		//
		// The write directory provides a base directory to which the system and services can write
		// files to.  If some of these files need to be public, it is suggested you create relative
		// symbolic links in the "public" folder.
		//

		'write_directory' => 'writable'
	]);
