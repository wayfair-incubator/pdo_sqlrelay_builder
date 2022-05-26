--TEST--
pdo_test.php query=unknown_table --test basic error reporting
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

test_query($pdo, "SELECT FOOBAR FROM UNKNOWN_FOOBAR_TABLE WHERE COL1 = 100");
?>
--EXPECT--
string(3) "PDO"
string(12) "PDOStatement"
bool(false)
array(3) {
  [0]=>
  string(5) "HY000"
  [1]=>
  int(208)
  [2]=>
  string(97) "[Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Invalid object name 'UNKNOWN_FOOBAR_TABLE'."
}
array(2) {
  ["column_count"]=>
  int(0)
  ["meta"]=>
  array(0) {
  }
}
array(0) {
}
