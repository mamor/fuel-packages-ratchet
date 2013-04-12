# fuel-packages-ratchet

* WebSocket Server by [Ratchet](http://socketo.me/)
* [ZeroMQ](http://www.zeromq.org/) is required
* [Samples] https://github.com/mp-php/fuel-ratchet

---

## Install ZeroMQ
* [Linux](http://madroom-project.blogspot.jp/2013/04/ubuntu-phpzeromq.html)
* [Mac OS X](http://madroom-project.blogspot.jp/2013/04/mampmaczeromq.html)
* [Windows](http://madroom-project.blogspot.jp/2013/04/xamppwindowszeromq.html)

## Install

### Getting code

	# In FuelPHP project root
	$ git submodule add git://github.com/mp-php/fuel-packages-ratchet.git fuel/packages/ratchet

### Install vendors

	$ cd fuel/packages/ratchet
	$ php composer.phar install

### Configuration

In app/config/config.php

	'always_load' => array('packages' => array(
		'ratchet',
		...

## Usage

	$ php oil r ratchet:help

## Run with Supervisor

	# Install with easy_install command
	$ sudo easy_install supervisor

	# Generate configure file
	$ echo_supervisord_conf > fuel/packages/ratchet/supervisor.conf

### Example for supervisor.conf

Add the following  
My_Ratchet_Ws is fuel/app/classes/my/ratchet.php that extends Ratchet_Ws

	[program:ratchet]
	command                 = php oil r ratchet:ws My_Ratchet_Ws 8080
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

	# Run
	$ sudo supervisord -c fuel/packages/ratchet/supervisor.conf

	# Check Status
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf status

	# Stop
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf stop all

	# Start
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf start all

	# Restart
	$ sudo supervisorctl -c fuel/packages/ratchet/supervisor.conf restart all

## License

Copyright 2013, Mamoru Otsuka. Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
