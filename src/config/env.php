<?php

return array(

	'docker' => file_exists("/.dockerenv"),
	'monitoringSoftwareListFileName' => env('MS_FILENAME', '.monitoring_softwares'),

);