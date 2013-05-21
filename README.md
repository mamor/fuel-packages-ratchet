# fuel-packages-ratchet

* WebSocket Server by [Ratchet](http://socketo.me/)
* [ZeroMQ](http://www.zeromq.org/) is required
* [Samples](https://github.com/mp-php/fuel-ratchet-samples)

---

## Install ZeroMQ
* [Linux](http://madroom-project.blogspot.jp/2013/04/ubuntu-phpzeromq.html)
* [Mac OS X](http://madroom-project.blogspot.jp/2013/04/mampmaczeromq.html)
* [Windows](http://madroom-project.blogspot.jp/2013/04/xamppwindowszeromq.html)

## Install
### Setup to fuel/packages/ratchet
* Use composer https://packagist.org/packages/mp-php/fuel-packages-ratchet
* git submodule add
* Download zip

If you use git submodule or download zip, you must install vendors

	$ cd fuel/packages/ratchet
	$ php composer.phar install

### Configuration

In app/config/config.php

	'always_load' => array('packages' => array(
		'ratchet',
		...

Copy packages/ratchet/config/ratchet.php to under app/config directory and edit

	<?php

	return array(
		'classes' => array(
			'default' => array(
				'domain' => 'example.com',
				'port' => '8001',
				'zmq_port' => '5555',
			),
			'Ratchet_Ws' => array(
				'domain' => 'example.com',
				'port' => '8001',
			),
			'Ratchet_Wamp' => array(
				'domain' => 'example.com',
				'port' => '8002',
				'zmq_port' => '5555',
			),
		),
	);

## Usage

	$ php oil r ratchet:help

## Run with Supervisor

	# Install with easy_install command
	$ sudo easy_install supervisor

	# Generate configure file
	$ echo_supervisord_conf > fuel/packages/ratchet/supervisor.conf

### Example for supervisor.conf

Add the following  
My_Ratchet_Ws is fuel/app/classes/my/ratchet/ws.php that extends Ratchet_Ws

	[program:ratchet]
	environment             = FUEL_ENV=production
	command                 = php oil r ratchet:ws My_Ratchet_Ws
	numprocs                = 1
	autostart               = true
	autorestart             = true
	user                    = root
	stdout_logfile          = fuel/app/logs/supervisor/info.log
	stdout_logfile_maxbytes = 1MB
	stderr_logfile          = fuel/app/logs/supervisor/error.log
	stderr_logfile_maxbytes = 1MB

### Example Commands

	# In FuelPHP project root

	# Up
	$ sudo supervisord -c fuel/packages/ratchet/supervisor.conf

	# Check Status
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf status

	# Stop
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf stop all

	# Start
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf start all

	# Restart
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf restart all

### Example Commands with Makefile

	# make up
	up:
		@echo 'Please manually run the following command:'
		@echo 'sudo supervisord -c fuel/packages/ratchet/supervisor.conf'

	# make down
	down:
		sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf stop all && sudo rm /tmp/supervisor.sock

	# make start-all
	start-all:
		sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf start all

	# make stop-all
	stop-all:
		sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf stop all

	# make restart-all
	restart-all:
		sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf restart all

	# make status
	status:
		sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf status

## License

Copyright 2013, Mamoru Otsuka. Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
