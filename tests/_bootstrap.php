<?php
// This is global bootstrap for autoloading
$stubs = glob(__DIR__.'/stubs/*Stub.php');

foreach ($stubs as $stub)
{
	require_once $stub;
}
