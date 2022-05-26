--TEST--
pdo_test.php query=test_types_extended -- test some more interesting types
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

$sql_test_types_extended_mssql = <<<GO
--query_name:test_types_extended_mssql--

select
  '999999999999999' as string_value_Test_001, 'bigint' as cast_type_Test_001,
  cast('999999999999999' as bigint) as cast_value_Test_001,

  '55.123' as string_value_Test_002, 'numeric' as cast_type_Test_002,
  cast('55.123' as numeric) as cast_value_Test_002,

  '55.123' as string_value_Test_003, 'numeric(10,5)' as cast_type_Test_003,
  cast('55.123' as numeric(10,5)) as cast_value_Test_003,

  '0' as string_value_Test_004, 'bit' as cast_type_Test_004,
  cast('0' as bit) as cast_value_Test_004,

  '94' as string_value_Test_005, 'smallint' as cast_type_Test_005,
  cast('94' as smallint) as cast_value_Test_005,

  '55.323' as string_value_Test_006, 'decimal' as cast_type_Test_006,
  cast('55.323' as decimal) as cast_value_Test_006,

  '55.323' as string_value_Test_007, 'decimal(10,5)' as cast_type_Test_007,
  cast('55.323' as decimal(10,5)) as cast_value_Test_007,

  '10.32' as string_value_Test_008, 'smallmoney' as cast_type_Test_008,
  cast('10.32' as smallmoney) as cast_value_Test_008,

  '9999999' as string_value_Test_009, 'int' as cast_type_Test_009,
  cast('9999999' as int) as cast_value_Test_009,

  '88' as string_value_Test_010, 'tinyint' as cast_type_Test_010,
  cast('88' as tinyint) as cast_value_Test_010,

  '12.32' as string_value_Test_011, 'money' as cast_type_Test_011,
  cast('12.32' as money) as cast_value_Test_011,

  '12345.6789' as string_value_Test_012, 'float' as cast_type_Test_012,
  cast('12345.6789' as float) as cast_value_Test_012,

  '12347.6789' as string_value_Test_013, 'real' as cast_type_Test_013,
  cast('12347.6789' as real) as cast_value_Test_013,

  '1958-01-15' as string_value_Test_014, 'date' as cast_type_Test_014,
  cast('1958-01-15' as date) as cast_value_Test_014,

  '1958-01-15 18:23:45' as string_value_Test_015, 'datetimeoffset' as cast_type_Test_015,
  cast('1958-01-15 18:23:45' as datetimeoffset) as cast_value_Test_015,

  '1958-01-15 18:24:46' as string_value_Test_016, 'datetime2' as cast_type_Test_016,
  cast('1958-01-15 18:24:46' as datetime2) as cast_value_Test_016,

  '1958-01-15 18:25:47' as string_value_Test_017, 'smalldatetime' as cast_type_Test_017,
  cast('1958-01-15 18:25:47' as smalldatetime) as cast_value_Test_017,

  '1958-01-15 18:26:48' as string_value_Test_018, 'datetime' as cast_type_Test_018,
  cast('1958-01-15 18:26:48' as datetime) as cast_value_Test_018,

--  Right now this type causes php to just stop processing further
--  without any error message. NOTE: the author was confused at the time about what timestamp meant,
--  it is not the ANSI SQL type, but a synonym for the ROWVERSION type,
--  so no wonder it caused a problem.
-- '1958-01-15 18:26:48' as string_value_Test_019, 'timestamp' as cast_type_Test_019,
-- cast('1958-01-15 18:26:48' as timestamp) as cast_value_Test_019,

  '23:59:59.999' as string_value_Test_020, 'time' as cast_type_Test_020,
  cast('23:59:59.999' as time) as cast_value_Test_020,

  'FOOBA1' as string_value_Test_021, 'char(6)' as cast_type_Test_021,
  cast('FOOBA1' as char(6)) as cast_value_Test_021,

  'FOOBA2' as string_value_Test_022, 'varchar(64)' as cast_type_Test_022,
  cast('FOOBA2' as varchar(64)) as cast_value_Test_022,

  'FOOBA3' as string_value_Test_023, 'varchar(max)' as cast_type_Test_023,
  cast('FOOBA3' as varchar(max)) as cast_value_Test_023,

  'FOOBA4' as string_value_Test_024, 'nchar(6)' as cast_type_Test_024,
  cast('FOOBA4' as nchar(6)) as cast_value_Test_024,

  'FOOBA5' as string_value_Test_025, 'nvarchar(64)' as cast_type_Test_025,
  cast('FOOBA5' as nvarchar(64)) as cast_value_Test_025,

  'FOOBA6' as string_value_Test_027, 'nvarchar(max)' as cast_type_Test_027,
  cast('FOOBA6' as nvarchar(max)) as cast_value_Test_027,

-- This is also problematic.
-- I think I left this out of pdo_test.php because it segfaulted
-- some drivers?
--  'FOOBA7' as string_value_Test_028, 'binary(6)' as cast_type_Test_028,
--  cast('FOOBA7' as binary(6)) as cast_value_Test_028,

--  'FOOBA8' as string_value_Test_029, 'varbinary(64)' as cast_type_Test_029,
--  cast('FOOBA8' as varbinary(64)) as cast_value_Test_029,

--  'FOOBA9' as string_value_Test_030, 'varbinary(max)' as cast_type_Test_030,
--  cast('FOOBA9' as varbinary(max)) as cast_value_Test_030,

  '31f528d4-6a5a-4257-a1a3-1acb56dd76d7' as string_value_Test_031, 'uniqueidentifier' as cast_type_Test_031,
  cast('31f528d4-6a5a-4257-a1a3-1acb56dd76d7' as uniqueidentifier) as cast_value_Test_031,

  '<document><element/></document>' as string_value_Test_032, 'xml' as cast_type_Test_032,
  cast('<document><element/></document>' as xml) as cast_value_Test_032,

  'FOOB10' as string_value_Test_033, 'text' as cast_type_Test_033,
  cast('FOOB10' as text) as cast_value_Test_033,

  'FOOB11' as string_value_Test_034, 'ntext' as cast_type_Test_034,
  cast('FOOB11' as ntext) as cast_value_Test_034,

  'FOOB12' as string_value_Test_035, 'image' as cast_type_Test_035,
  cast('FOOB12' as image) as cast_value_Test_035,

  'FOOB13' as string_value_Test_036, 'sql_variant' as cast_type_Test_036,
  cast('FOOB13' as sql_variant) as cast_value_Test_036,

  'NULL' as string_value_Test_037, 'bit' as cast_type_Test_037,
  cast(NULL as bit) as cast_value_Test_037,

  'TRUE' as string_value_Test_038, 'bit' as cast_type_Test_038,
  cast('TRUE' as bit) as cast_value_Test_038,

  'FALSE' as string_value_Test_039, 'bit' as cast_type_Test_039,
  cast('FALSE' as bit) as cast_value_Test_039
GO;

test_query($pdo, $sql_test_types_extended_mssql);
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
  int(102)
  ["meta"]=>
  array(102) {
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
      string(21) "string_value_Test_001"
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
      string(18) "cast_type_Test_001"
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
      string(19) "cast_value_Test_001"
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
      string(21) "string_value_Test_002"
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
      string(18) "cast_type_Test_002"
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
      string(19) "cast_value_Test_002"
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
      string(21) "string_value_Test_003"
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
      string(18) "cast_type_Test_003"
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
      string(19) "cast_value_Test_003"
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
      string(21) "string_value_Test_004"
      ["len"]=>
      int(1)
      ["precision"]=>
      int(1)
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
      string(18) "cast_type_Test_004"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [11]=>
    array(7) {
      ["native_type"]=>
      string(3) "BIT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(19) "cast_value_Test_004"
      ["len"]=>
      int(1)
      ["precision"]=>
      int(1)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
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
      string(21) "string_value_Test_005"
      ["len"]=>
      int(2)
      ["precision"]=>
      int(2)
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
      string(18) "cast_type_Test_005"
      ["len"]=>
      int(8)
      ["precision"]=>
      int(8)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [14]=>
    array(7) {
      ["native_type"]=>
      string(8) "SMALLINT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(19) "cast_value_Test_005"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
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
      string(21) "string_value_Test_006"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
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
      string(18) "cast_type_Test_006"
      ["len"]=>
      int(7)
      ["precision"]=>
      int(7)
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
      string(19) "cast_value_Test_006"
      ["len"]=>
      int(18)
      ["precision"]=>
      int(18)
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
      string(21) "string_value_Test_007"
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
      string(18) "cast_type_Test_007"
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
      string(19) "cast_value_Test_007"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [21]=>
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
      string(21) "string_value_Test_008"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [22]=>
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
      string(18) "cast_type_Test_008"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [23]=>
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
      string(19) "cast_value_Test_008"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [24]=>
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
      string(21) "string_value_Test_009"
      ["len"]=>
      int(7)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [25]=>
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
      string(18) "cast_type_Test_009"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [26]=>
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
      string(19) "cast_value_Test_009"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [27]=>
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
      string(21) "string_value_Test_010"
      ["len"]=>
      int(2)
      ["precision"]=>
      int(2)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [28]=>
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
      string(18) "cast_type_Test_010"
      ["len"]=>
      int(7)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [29]=>
    array(7) {
      ["native_type"]=>
      string(7) "TINYINT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(19) "cast_value_Test_010"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [30]=>
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
      string(21) "string_value_Test_011"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [31]=>
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
      string(18) "cast_type_Test_011"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [32]=>
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
      string(19) "cast_value_Test_011"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [33]=>
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
      string(21) "string_value_Test_012"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [34]=>
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
      string(18) "cast_type_Test_012"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [35]=>
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
      string(19) "cast_value_Test_012"
      ["len"]=>
      int(53)
      ["precision"]=>
      int(53)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [36]=>
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
      string(21) "string_value_Test_013"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [37]=>
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
      string(18) "cast_type_Test_013"
      ["len"]=>
      int(4)
      ["precision"]=>
      int(4)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [38]=>
    array(7) {
      ["native_type"]=>
      string(4) "REAL"
      ["pdo_type"]=>
      int(2)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(19) "cast_value_Test_013"
      ["len"]=>
      int(24)
      ["precision"]=>
      int(24)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [39]=>
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
      string(21) "string_value_Test_014"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [40]=>
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
      string(18) "cast_type_Test_014"
      ["len"]=>
      int(4)
      ["precision"]=>
      int(4)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [41]=>
    array(7) {
      ["native_type"]=>
      string(8) "DATETIME"
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
      string(19) "cast_value_Test_014"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(0)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [42]=>
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
      string(21) "string_value_Test_015"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [43]=>
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
      string(18) "cast_type_Test_015"
      ["len"]=>
      int(14)
      ["precision"]=>
      int(14)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [44]=>
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
      string(19) "cast_value_Test_015"
      ["len"]=>
      int(34)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [45]=>
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
      string(21) "string_value_Test_016"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [46]=>
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
      string(18) "cast_type_Test_016"
      ["len"]=>
      int(9)
      ["precision"]=>
      int(9)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [47]=>
    array(7) {
      ["native_type"]=>
      string(8) "DATETIME"
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
      string(19) "cast_value_Test_016"
      ["len"]=>
      int(27)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [48]=>
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
      string(21) "string_value_Test_017"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [49]=>
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
      string(18) "cast_type_Test_017"
      ["len"]=>
      int(13)
      ["precision"]=>
      int(13)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [50]=>
    array(7) {
      ["native_type"]=>
      string(8) "DATETIME"
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
      string(19) "cast_value_Test_017"
      ["len"]=>
      int(16)
      ["precision"]=>
      int(0)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [51]=>
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
      string(21) "string_value_Test_018"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [52]=>
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
      string(18) "cast_type_Test_018"
      ["len"]=>
      int(8)
      ["precision"]=>
      int(8)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [53]=>
    array(7) {
      ["native_type"]=>
      string(8) "DATETIME"
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
      string(19) "cast_value_Test_018"
      ["len"]=>
      int(23)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [54]=>
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
      string(21) "string_value_Test_020"
      ["len"]=>
      int(12)
      ["precision"]=>
      int(12)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [55]=>
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
      string(18) "cast_type_Test_020"
      ["len"]=>
      int(4)
      ["precision"]=>
      int(4)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [56]=>
    array(7) {
      ["native_type"]=>
      string(4) "TIME"
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
      string(19) "cast_value_Test_020"
      ["len"]=>
      int(16)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [57]=>
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
      string(21) "string_value_Test_021"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [58]=>
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
      string(18) "cast_type_Test_021"
      ["len"]=>
      int(7)
      ["precision"]=>
      int(7)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [59]=>
    array(7) {
      ["native_type"]=>
      string(4) "CHAR"
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
      string(19) "cast_value_Test_021"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [60]=>
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
      string(21) "string_value_Test_022"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [61]=>
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
      string(18) "cast_type_Test_022"
      ["len"]=>
      int(11)
      ["precision"]=>
      int(11)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [62]=>
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
      string(19) "cast_value_Test_022"
      ["len"]=>
      int(64)
      ["precision"]=>
      int(64)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [63]=>
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
      string(21) "string_value_Test_023"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [64]=>
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
      string(18) "cast_type_Test_023"
      ["len"]=>
      int(12)
      ["precision"]=>
      int(12)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [65]=>
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
      string(19) "cast_value_Test_023"
      ["len"]=>
      int(0)
      ["precision"]=>
      int(0)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [66]=>
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
      string(21) "string_value_Test_024"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [67]=>
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
      string(18) "cast_type_Test_024"
      ["len"]=>
      int(8)
      ["precision"]=>
      int(8)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [68]=>
    array(7) {
      ["native_type"]=>
      string(5) "NCHAR"
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
      string(19) "cast_value_Test_024"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [69]=>
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
      string(21) "string_value_Test_025"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [70]=>
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
      string(18) "cast_type_Test_025"
      ["len"]=>
      int(12)
      ["precision"]=>
      int(12)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [71]=>
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
      string(19) "cast_value_Test_025"
      ["len"]=>
      int(64)
      ["precision"]=>
      int(64)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [72]=>
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
      string(21) "string_value_Test_027"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [73]=>
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
      string(18) "cast_type_Test_027"
      ["len"]=>
      int(13)
      ["precision"]=>
      int(13)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [74]=>
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
      string(19) "cast_value_Test_027"
      ["len"]=>
      int(0)
      ["precision"]=>
      int(0)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [75]=>
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
      string(21) "string_value_Test_031"
      ["len"]=>
      int(36)
      ["precision"]=>
      int(36)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [76]=>
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
      string(18) "cast_type_Test_031"
      ["len"]=>
      int(16)
      ["precision"]=>
      int(16)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [77]=>
    array(7) {
      ["native_type"]=>
      string(16) "UNIQUEIDENTIFIER"
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
      string(19) "cast_value_Test_031"
      ["len"]=>
      int(36)
      ["precision"]=>
      int(36)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [78]=>
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
      string(21) "string_value_Test_032"
      ["len"]=>
      int(31)
      ["precision"]=>
      int(31)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [79]=>
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
      string(18) "cast_type_Test_032"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [80]=>
    array(7) {
      ["native_type"]=>
      string(3) "XML"
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
      string(19) "cast_value_Test_032"
      ["len"]=>
      int(0)
      ["precision"]=>
      int(0)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [81]=>
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
      string(21) "string_value_Test_033"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [82]=>
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
      string(18) "cast_type_Test_033"
      ["len"]=>
      int(4)
      ["precision"]=>
      int(4)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [83]=>
    array(7) {
      ["native_type"]=>
      string(11) "LONGVARCHAR"
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
      string(19) "cast_value_Test_033"
      ["len"]=>
      string(8) "REDACTED"
      ["precision"]=>
      string(8) "REDACTED"
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [84]=>
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
      string(21) "string_value_Test_034"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [85]=>
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
      string(18) "cast_type_Test_034"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [86]=>
    array(7) {
      ["native_type"]=>
      string(5) "NTEXT"
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
      string(19) "cast_value_Test_034"
      ["len"]=>
      string(8) "REDACTED"
      ["precision"]=>
      string(8) "REDACTED"
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [87]=>
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
      string(21) "string_value_Test_035"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [88]=>
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
      string(18) "cast_type_Test_035"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [89]=>
    array(7) {
      ["native_type"]=>
      string(13) "LONGVARBINARY"
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
      string(19) "cast_value_Test_035"
      ["len"]=>
      string(8) "REDACTED"
      ["precision"]=>
      string(8) "REDACTED"
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [90]=>
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
      string(21) "string_value_Test_036"
      ["len"]=>
      int(6)
      ["precision"]=>
      int(6)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [91]=>
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
      string(18) "cast_type_Test_036"
      ["len"]=>
      int(11)
      ["precision"]=>
      int(11)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [92]=>
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
      string(19) "cast_value_Test_036"
      ["len"]=>
      int(8000)
      ["precision"]=>
      int(8000)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [93]=>
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
      string(21) "string_value_Test_037"
      ["len"]=>
      int(4)
      ["precision"]=>
      int(4)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [94]=>
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
      string(18) "cast_type_Test_037"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [95]=>
    array(7) {
      ["native_type"]=>
      string(3) "BIT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(19) "cast_value_Test_037"
      ["len"]=>
      int(1)
      ["precision"]=>
      int(1)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [96]=>
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
      string(21) "string_value_Test_038"
      ["len"]=>
      int(4)
      ["precision"]=>
      int(4)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [97]=>
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
      string(18) "cast_type_Test_038"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [98]=>
    array(7) {
      ["native_type"]=>
      string(3) "BIT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(19) "cast_value_Test_038"
      ["len"]=>
      int(1)
      ["precision"]=>
      int(1)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [99]=>
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
      string(21) "string_value_Test_039"
      ["len"]=>
      int(5)
      ["precision"]=>
      int(5)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [100]=>
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
      string(18) "cast_type_Test_039"
      ["len"]=>
      int(3)
      ["precision"]=>
      int(3)
      ["pdo_type_name"]=>
      string(9) "PARAM_STR"
    }
    [101]=>
    array(7) {
      ["native_type"]=>
      string(3) "BIT"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(2) {
        [0]=>
        string(8) "nullable"
        [1]=>
        string(8) "unsigned"
      }
      ["name"]=>
      string(19) "cast_value_Test_039"
      ["len"]=>
      int(1)
      ["precision"]=>
      int(1)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
  }
}
array(1) {
  [0]=>
  array(102) {
    ["string_value_Test_001"]=>
    string(15) "999999999999999"
    ["cast_type_Test_001"]=>
    string(6) "bigint"
    ["cast_value_Test_001"]=>
    int(999999999999999)
    ["string_value_Test_002"]=>
    string(6) "55.123"
    ["cast_type_Test_002"]=>
    string(7) "numeric"
    ["cast_value_Test_002"]=>
    float(55)
    ["string_value_Test_003"]=>
    string(6) "55.123"
    ["cast_type_Test_003"]=>
    string(13) "numeric(10,5)"
    ["cast_value_Test_003"]=>
    float(55.123)
    ["string_value_Test_004"]=>
    string(1) "0"
    ["cast_type_Test_004"]=>
    string(3) "bit"
    ["cast_value_Test_004"]=>
    int(0)
    ["string_value_Test_005"]=>
    string(2) "94"
    ["cast_type_Test_005"]=>
    string(8) "smallint"
    ["cast_value_Test_005"]=>
    int(94)
    ["string_value_Test_006"]=>
    string(6) "55.323"
    ["cast_type_Test_006"]=>
    string(7) "decimal"
    ["cast_value_Test_006"]=>
    float(55)
    ["string_value_Test_007"]=>
    string(6) "55.323"
    ["cast_type_Test_007"]=>
    string(13) "decimal(10,5)"
    ["cast_value_Test_007"]=>
    float(55.323)
    ["string_value_Test_008"]=>
    string(5) "10.32"
    ["cast_type_Test_008"]=>
    string(10) "smallmoney"
    ["cast_value_Test_008"]=>
    float(10.32)
    ["string_value_Test_009"]=>
    string(7) "9999999"
    ["cast_type_Test_009"]=>
    string(3) "int"
    ["cast_value_Test_009"]=>
    int(9999999)
    ["string_value_Test_010"]=>
    string(2) "88"
    ["cast_type_Test_010"]=>
    string(7) "tinyint"
    ["cast_value_Test_010"]=>
    int(88)
    ["string_value_Test_011"]=>
    string(5) "12.32"
    ["cast_type_Test_011"]=>
    string(5) "money"
    ["cast_value_Test_011"]=>
    float(12.32)
    ["string_value_Test_012"]=>
    string(10) "12345.6789"
    ["cast_type_Test_012"]=>
    string(5) "float"
    ["cast_value_Test_012"]=>
    float(12345.6789)
    ["string_value_Test_013"]=>
    string(10) "12347.6789"
    ["cast_type_Test_013"]=>
    string(4) "real"
    ["cast_value_Test_013"]=>
    float(12347.679)
    ["string_value_Test_014"]=>
    string(10) "1958-01-15"
    ["cast_type_Test_014"]=>
    string(4) "date"
    ["cast_value_Test_014"]=>
    string(10) "1958-01-15"
    ["string_value_Test_015"]=>
    string(19) "1958-01-15 18:23:45"
    ["cast_type_Test_015"]=>
    string(14) "datetimeoffset"
    ["cast_value_Test_015"]=>
    string(34) "1958-01-15 18:23:45.0000000 +00:00"
    ["string_value_Test_016"]=>
    string(19) "1958-01-15 18:24:46"
    ["cast_type_Test_016"]=>
    string(9) "datetime2"
    ["cast_value_Test_016"]=>
    string(27) "1958-01-15 18:24:46.0000000"
    ["string_value_Test_017"]=>
    string(19) "1958-01-15 18:25:47"
    ["cast_type_Test_017"]=>
    string(13) "smalldatetime"
    ["cast_value_Test_017"]=>
    string(19) "1958-01-15 18:26:00"
    ["string_value_Test_018"]=>
    string(19) "1958-01-15 18:26:48"
    ["cast_type_Test_018"]=>
    string(8) "datetime"
    ["cast_value_Test_018"]=>
    string(23) "1958-01-15 18:26:48.000"
    ["string_value_Test_020"]=>
    string(12) "23:59:59.999"
    ["cast_type_Test_020"]=>
    string(4) "time"
    ["cast_value_Test_020"]=>
    string(16) "23:59:59.9990000"
    ["string_value_Test_021"]=>
    string(6) "FOOBA1"
    ["cast_type_Test_021"]=>
    string(7) "char(6)"
    ["cast_value_Test_021"]=>
    string(6) "FOOBA1"
    ["string_value_Test_022"]=>
    string(6) "FOOBA2"
    ["cast_type_Test_022"]=>
    string(11) "varchar(64)"
    ["cast_value_Test_022"]=>
    string(6) "FOOBA2"
    ["string_value_Test_023"]=>
    string(6) "FOOBA3"
    ["cast_type_Test_023"]=>
    string(12) "varchar(max)"
    ["cast_value_Test_023"]=>
    string(6) "FOOBA3"
    ["string_value_Test_024"]=>
    string(6) "FOOBA4"
    ["cast_type_Test_024"]=>
    string(8) "nchar(6)"
    ["cast_value_Test_024"]=>
    string(6) "FOOBA4"
    ["string_value_Test_025"]=>
    string(6) "FOOBA5"
    ["cast_type_Test_025"]=>
    string(12) "nvarchar(64)"
    ["cast_value_Test_025"]=>
    string(6) "FOOBA5"
    ["string_value_Test_027"]=>
    string(6) "FOOBA6"
    ["cast_type_Test_027"]=>
    string(13) "nvarchar(max)"
    ["cast_value_Test_027"]=>
    string(6) "FOOBA6"
    ["string_value_Test_031"]=>
    string(36) "31f528d4-6a5a-4257-a1a3-1acb56dd76d7"
    ["cast_type_Test_031"]=>
    string(16) "uniqueidentifier"
    ["cast_value_Test_031"]=>
    string(36) "31F528D4-6A5A-4257-A1A3-1ACB56DD76D7"
    ["string_value_Test_032"]=>
    string(31) "<document><element/></document>"
    ["cast_type_Test_032"]=>
    string(3) "xml"
    ["cast_value_Test_032"]=>
    string(31) "<document><element/></document>"
    ["string_value_Test_033"]=>
    string(6) "FOOB10"
    ["cast_type_Test_033"]=>
    string(4) "text"
    ["cast_value_Test_033"]=>
    string(6) "FOOB10"
    ["string_value_Test_034"]=>
    string(6) "FOOB11"
    ["cast_type_Test_034"]=>
    string(5) "ntext"
    ["cast_value_Test_034"]=>
    string(6) "FOOB11"
    ["string_value_Test_035"]=>
    string(6) "FOOB12"
    ["cast_type_Test_035"]=>
    string(5) "image"
    ["cast_value_Test_035"]=>
    string(12) "464F4F423132"
    ["string_value_Test_036"]=>
    string(6) "FOOB13"
    ["cast_type_Test_036"]=>
    string(11) "sql_variant"
    ["cast_value_Test_036"]=>
    string(6) "FOOB13"
    ["string_value_Test_037"]=>
    string(4) "NULL"
    ["cast_type_Test_037"]=>
    string(3) "bit"
    ["cast_value_Test_037"]=>
    NULL
    ["string_value_Test_038"]=>
    string(4) "TRUE"
    ["cast_type_Test_038"]=>
    string(3) "bit"
    ["cast_value_Test_038"]=>
    int(1)
    ["string_value_Test_039"]=>
    string(5) "FALSE"
    ["cast_type_Test_039"]=>
    string(3) "bit"
    ["cast_value_Test_039"]=>
    int(0)
  }
}
