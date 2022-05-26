--TEST--
pdo_test.php query=test_types_problematic --types that cause some drivers serious problems
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

$sql_test_types_problematic_mssql = <<<GO
--query_name:test_types_problematic_mssql--

select

 '1958-01-15 18:26:48' as string_value_Test_019, 'datetimeoffset' as cast_type_Test_019,
 cast('1958-01-15 18:26:48' as datetimeoffset) as cast_value_Test_019,

 'FOOBA7' as string_value_Test_028, 'binary(6)' as cast_type_Test_028,
 cast('FOOBA7' as binary(6)) as cast_value_Test_028,

 'FOOBA8' as string_value_Test_029, 'varbinary(64)' as cast_type_Test_029,
 cast('FOOBA8' as varbinary(64)) as cast_value_Test_029,

 'FOOBA9' as string_value_Test_030, 'varbinary(max)' as cast_type_Test_030,
 cast('FOOBA9' as varbinary(max)) as cast_value_Test_030

GO;

test_query($pdo, $sql_test_types_problematic_mssql);
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
  int(12)
  ["meta"]=>
  array(12) {
    [0]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(21) "string_value_Test_019"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [1]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(18) "cast_type_Test_019"
      ["len"]=>
      int(14)
      ["precision"]=>
      int(14)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [2]=>
    array(7) {
      ["native_type"]=>
      string(14) "DATETIMEOFFSET"
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
      string(19) "cast_value_Test_019"
      ["len"]=>
      int(34)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [3]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(21) "string_value_Test_028"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [4]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(18) "cast_type_Test_028"
      ["len"]=>
      int(9)
      ["precision"]=>
      int(9)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [5]=>
    array(7) {
      ["native_type"]=>
      string(6) "BINARY"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(3) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
        [2]=>
        string(6) "binary"
      }
      ["name"]=>
      string(19) "cast_value_Test_028"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [6]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(21) "string_value_Test_029"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [7]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(18) "cast_type_Test_029"
      ["len"]=>
      int(13)
      ["precision"]=>
      int(13)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [8]=>
    array(7) {
      ["native_type"]=>
      string(9) "VARBINARY"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(3) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
        [2]=>
        string(6) "binary"
      }
      ["name"]=>
      string(19) "cast_value_Test_029"
      ["len"]=>
      int(64)
      ["precision"]=>
      int(64)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [9]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(21) "string_value_Test_030"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [10]=>
    array(7) {
      ["native_type"]=>
      string(7) "VARCHAR"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(18) "cast_type_Test_030"
      ["len"]=>
      int(14)
      ["precision"]=>
      int(14)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [11]=>
    array(7) {
      ["native_type"]=>
      string(9) "VARBINARY"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(3) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
        [2]=>
        string(6) "binary"
      }
      ["name"]=>
      string(19) "cast_value_Test_030"
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
  array(12) {
    ["string_value_Test_019"]=>
    string(19) "1958-01-15 18:26:48"
    ["cast_type_Test_019"]=>
    string(14) "datetimeoffset"
    ["cast_value_Test_019"]=>
    string(34) "1958-01-15 18:26:48.0000000 +00:00"
    ["string_value_Test_028"]=>
    string(6) "FOOBA7"
    ["cast_type_Test_028"]=>
    string(9) "binary(6)"
    ["cast_value_Test_028"]=>
    string(12) "464F4F424137"
    ["string_value_Test_029"]=>
    string(6) "FOOBA8"
    ["cast_type_Test_029"]=>
    string(13) "varbinary(64)"
    ["cast_value_Test_029"]=>
    string(12) "464F4F424138"
    ["string_value_Test_030"]=>
    string(6) "FOOBA9"
    ["cast_type_Test_030"]=>
    string(14) "varbinary(max)"
    ["cast_value_Test_030"]=>
    string(12) "464F4F424139"
  }
}
