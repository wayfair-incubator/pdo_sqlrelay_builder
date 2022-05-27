--TEST--
pdo_test.php query=test_types -- return basic types.
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

$sql_test_types_mssql = <<<GO
--query_name:test_types_mssql--

select
  '999999999999999' as Test_001_string_value,
  'bigint' as Test_001_cast_type___,
  cast('999999999999999' as BIGINT) as Test_001_cast_value__,

  '55.123' as Test_002_string_value,
  'numeric' as Test_002_cast_type___,
  cast('55.123' as numeric) as Test_002_cast_value__,

  '55.123' as Test_003_string_value,
  'numeric(10,5)' as Test_003_cast_type___,
  cast('55.123' as numeric(10,5)) as Test_003_cast_value__,

  '55.123' as Test_004_string_value,
  'float' as Test_004_cast_type___,
  cast('55.123' as float) as Test_004_cast_value__,

  '55123' as Test_005_string_value,
  'int' as Test_005_cast_type___,
  cast('55123' as int) as Test_005_cast_value__,

  '12.32' as Test_006_string_value,
  'money' as Test_006_cast_type___,
  cast('12.32' as money) as Test_006_cast_value__,

  '55.323' as Test_007_string_value,
  'decimal(10,5)'  as Test_007_cast_type___,
  cast('55.323' as decimal(10,5)) as Test_007_cast_value__

GO;

test_query($pdo, $sql_test_types_mssql);
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
  int(21)
  ["meta"]=>
  array(21) {
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
      string(21) "Test_001_string_value"
      ["len"]=>
      int(15)
      ["precision"]=>
      int(15)
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
      string(21) "Test_001_cast_type___"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [2]=>
    array(7) {
      ["native_type"]=>
      string(6) "BIGINT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_001_cast_value__"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
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
      string(21) "Test_002_string_value"
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
      string(21) "Test_002_cast_type___"
      ["len"]=>
      int(7)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [5]=>
    array(7) {
      ["native_type"]=>
      string(7) "NUMERIC"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_002_cast_value__"
      ["len"]=>
      int(18)
      ["precision"]=>
      int(18)
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
      string(21) "Test_003_string_value"
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
      string(21) "Test_003_cast_type___"
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
      string(7) "NUMERIC"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_003_cast_value__"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
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
      string(21) "Test_004_string_value"
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
      string(21) "Test_004_cast_type___"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [11]=>
    array(7) {
      ["native_type"]=>
      string(5) "FLOAT"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_004_cast_value__"
      ["len"]=>
      int(53)
      ["precision"]=>
      int(53)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [12]=>
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
      string(21) "Test_005_string_value"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [13]=>
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
      string(21) "Test_005_cast_type___"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [14]=>
    array(7) {
      ["native_type"]=>
      string(7) "INTEGER"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_005_cast_value__"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [15]=>
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
      string(21) "Test_006_string_value"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [16]=>
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
      string(21) "Test_006_cast_type___"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [17]=>
    array(7) {
      ["native_type"]=>
      string(7) "DECIMAL"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_006_cast_value__"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [18]=>
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
      string(21) "Test_007_string_value"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [19]=>
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
      string(21) "Test_007_cast_type___"
      ["len"]=>
      int(13)
      ["precision"]=>
      int(13)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [20]=>
    array(7) {
      ["native_type"]=>
      string(7) "DECIMAL"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(21) "Test_007_cast_value__"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
  }
}
array(1) {
  [0]=>
  array(21) {
    ["Test_001_string_value"]=>
    string(15) "999999999999999"
    ["Test_001_cast_type___"]=>
    string(6) "bigint"
    ["Test_001_cast_value__"]=>
    int(999999999999999)
    ["Test_002_string_value"]=>
    string(6) "55.123"
    ["Test_002_cast_type___"]=>
    string(7) "numeric"
    ["Test_002_cast_value__"]=>
    float(55)
    ["Test_003_string_value"]=>
    string(6) "55.123"
    ["Test_003_cast_type___"]=>
    string(13) "numeric(10,5)"
    ["Test_003_cast_value__"]=>
    float(55.123)
    ["Test_004_string_value"]=>
    string(6) "55.123"
    ["Test_004_cast_type___"]=>
    string(5) "float"
    ["Test_004_cast_value__"]=>
    float(55.123)
    ["Test_005_string_value"]=>
    string(5) "55123"
    ["Test_005_cast_type___"]=>
    string(3) "int"
    ["Test_005_cast_value__"]=>
    int(55123)
    ["Test_006_string_value"]=>
    string(5) "12.32"
    ["Test_006_cast_type___"]=>
    string(5) "money"
    ["Test_006_cast_value__"]=>
    float(12.32)
    ["Test_007_string_value"]=>
    string(6) "55.323"
    ["Test_007_cast_type___"]=>
    string(13) "decimal(10,5)"
    ["Test_007_cast_value__"]=>
    float(55.323)
  }
}
