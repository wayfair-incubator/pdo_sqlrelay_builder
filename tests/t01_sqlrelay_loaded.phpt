--TEST--
PDO::getAvailableDrivers() function - make sure sqlrelay is available.
--FILE--
<?php
var_dump(in_array("sqlrelay", PDO::getAvailableDrivers()));
?>
--EXPECT--
bool(true)
