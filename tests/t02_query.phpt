--TEST--
connect and query - make a connection and query.
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

$sql1 = "SELECT CAST('123.4' AS VARCHAR) AS F1,
                CAST('FOOBAR' AS NVARCHAR(MAX)) S2";

test_query($pdo, $sql1);
?>
--EXPECT--
string(3) "PDO"
string(12) "PDOStatement"
bool(true)
array(3) {
  [0]=>
  string(5) "00000"
  [1]=>
  int(0)
  [2]=>
  NULL
}
array(2) {
  ["column_count"]=>
  int(2)
  ["meta"]=>
  array(2) {
    [0]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(2) "F1"
      ["len"]=>
      int(30)
      ["precision"]=>
      int(30)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [1]=>
    array(7) {
      ["native_type"]=>
      string(8) "NVARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(2) "S2"
      ["len"]=>
      int(0)
      ["precision"]=>
      int(0)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
  }
}
array(1) {
  [0]=>
  array(2) {
    ["F1"]=>
    string(5) "123.4"
    ["S2"]=>
    string(6) "FOOBAR"
  }
}
