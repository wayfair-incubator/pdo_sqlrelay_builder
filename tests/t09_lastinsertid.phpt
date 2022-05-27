--TEST--
pdo_test.php --test some transaction features.
--SKIPIF--
<?php if(
(!extension_loaded('pdo_sqlrelay')) ||
( ((PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION) <= 8.0) && empty(getenv("RUN_FAILING_TESTS")) )
) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

$table_name = "TEMP1";

$sql_create_temp = <<<GO
create table #{$table_name} (
 MYID BIGINT NOT NULL IDENTITY(99999999999, 9),
 MYNAME NVARCHAR(100) NOT NULL
)
GO;

$sql_drop_temp = <<<GO
drop table #{$table_name}
GO;

$sql_drop_temp_if = <<<GO
IF OBJECT_ID('tempdb.dbo.#{$table_name}') IS NOT NULL DROP TABLE #{$table_name}
GO;

$sql_insert = <<<GO
INSERT INTO #{$table_name} (MYNAME) VALUES (:MYNAME)
GO;

$sql_select = <<<GO
SELECT * FROM #{$table_name}
GO;

test_query($pdo, $sql_drop_temp_if);
test_query($pdo, $sql_create_temp);
test_query($pdo, $sql_insert, ':MYNAME', PDO::PARAM_STR, 'This is my name');
var_dump(['lastInsertId' => $pdo->lastInsertId()]);
test_query($pdo, $sql_insert, ':MYNAME', PDO::PARAM_STR, 'This is not my name');
var_dump(['lastInsertId' => $pdo->lastInsertId()]);
test_query($pdo, $sql_select);

test_query($pdo, $sql_drop_temp);

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
  int(0)
  ["meta"]=>
  array(0) {
  }
}
array(0) {
}
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
  int(0)
  ["meta"]=>
  array(0) {
  }
}
array(0) {
}
string(12) "PDOStatement"
bool(true)
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
  int(0)
  ["meta"]=>
  array(0) {
  }
}
array(0) {
}
array(1) {
  ["lastInsertId"]=>
  string(11) "99999999999"
}
string(12) "PDOStatement"
bool(true)
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
  int(0)
  ["meta"]=>
  array(0) {
  }
}
array(0) {
}
array(1) {
  ["lastInsertId"]=>
  string(12) "100000000008"
}
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
      string(6) "BIGINT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(1) {
        [0]=>
        string(14) "auto_increment"
      }
      ["name"]=>
      string(4) "MYID"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [1]=>
    array(7) {
      ["native_type"]=>
      string(8) "NVARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(6) "MYNAME"
      ["len"]=>
      int(100)
      ["precision"]=>
      int(100)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
  }
}
array(2) {
  [0]=>
  array(2) {
    ["MYID"]=>
    int(99999999999)
    ["MYNAME"]=>
    string(15) "This is my name"
  }
  [1]=>
  array(2) {
    ["MYID"]=>
    int(100000000008)
    ["MYNAME"]=>
    string(19) "This is not my name"
  }
}
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
  int(0)
  ["meta"]=>
  array(0) {
  }
}
array(0) {
}
