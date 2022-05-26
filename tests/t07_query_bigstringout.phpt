--TEST--
pdo_test.php query=bigstringout --returning larger amounts of data
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

  $sql_mssql = <<<GO
BEGIN
 SET NOCOUNT ON
 DECLARE @STUFF NVARCHAR(MAX) = ''
 DECLARE @J INT = 0
 DECLARE @N INT = 100
 DECLARE @CHUNK_SIZE INT = (:string_length / @N) + 1
 DECLARE @CHUNK NVARCHAR(MAX) = REPLICATE(CAST('x' as NVARCHAR(MAX)), @CHUNK_SIZE)
 WHILE @J < @N BEGIN
  SET @J = @J + 1
  SET @STUFF = @STUFF + @CHUNK + N'-' + CAST(@J AS NVARCHAR(32))
 END
 SELECT @CHUNK_SIZE AS CHUNK_SIZE,
        DATALENGTH(@STUFF) AS STUFF_DATALENGTH,
        LEN(@STUFF) AS STUFF_LEN,
        @STUFF AS STUFF
END
GO;

test_query($pdo, $sql_mssql, 'string_length', PDO::PARAM_INT, 100);
test_query($pdo, $sql_mssql, 'string_length', PDO::PARAM_INT, 1000);
?>
--EXPECT--
string(3) "PDO"
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
  int(4)
  ["meta"]=>
  array(4) {
    [0]=>
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
      string(10) "CHUNK_SIZE"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [1]=>
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
      string(16) "STUFF_DATALENGTH"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
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
      string(9) "STUFF_LEN"
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
      string(5) "STUFF"
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
  array(4) {
    ["CHUNK_SIZE"]=>
    int(2)
    ["STUFF_DATALENGTH"]=>
    int(984)
    ["STUFF_LEN"]=>
    int(492)
    ["STUFF"]=>
    string(492) "xx-1xx-2xx-3xx-4xx-5xx-6xx-7xx-8xx-9xx-10xx-11xx-12xx-13xx-14xx-15xx-16xx-17xx-18xx-19xx-20xx-21xx-22xx-23xx-24xx-25xx-26xx-27xx-28xx-29xx-30xx-31xx-32xx-33xx-34xx-35xx-36xx-37xx-38xx-39xx-40xx-41xx-42xx-43xx-44xx-45xx-46xx-47xx-48xx-49xx-50xx-51xx-52xx-53xx-54xx-55xx-56xx-57xx-58xx-59xx-60xx-61xx-62xx-63xx-64xx-65xx-66xx-67xx-68xx-69xx-70xx-71xx-72xx-73xx-74xx-75xx-76xx-77xx-78xx-79xx-80xx-81xx-82xx-83xx-84xx-85xx-86xx-87xx-88xx-89xx-90xx-91xx-92xx-93xx-94xx-95xx-96xx-97xx-98xx-99xx-100"
  }
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
  int(4)
  ["meta"]=>
  array(4) {
    [0]=>
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
      string(10) "CHUNK_SIZE"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [1]=>
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
      string(16) "STUFF_DATALENGTH"
      ["len"]=>
      int(19)
      ["precision"]=>
      int(19)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
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
      string(9) "STUFF_LEN"
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
      string(5) "STUFF"
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
  array(4) {
    ["CHUNK_SIZE"]=>
    int(11)
    ["STUFF_DATALENGTH"]=>
    int(2784)
    ["STUFF_LEN"]=>
    int(1392)
    ["STUFF"]=>
    string(1392) "xxxxxxxxxxx-1xxxxxxxxxxx-2xxxxxxxxxxx-3xxxxxxxxxxx-4xxxxxxxxxxx-5xxxxxxxxxxx-6xxxxxxxxxxx-7xxxxxxxxxxx-8xxxxxxxxxxx-9xxxxxxxxxxx-10xxxxxxxxxxx-11xxxxxxxxxxx-12xxxxxxxxxxx-13xxxxxxxxxxx-14xxxxxxxxxxx-15xxxxxxxxxxx-16xxxxxxxxxxx-17xxxxxxxxxxx-18xxxxxxxxxxx-19xxxxxxxxxxx-20xxxxxxxxxxx-21xxxxxxxxxxx-22xxxxxxxxxxx-23xxxxxxxxxxx-24xxxxxxxxxxx-25xxxxxxxxxxx-26xxxxxxxxxxx-27xxxxxxxxxxx-28xxxxxxxxxxx-29xxxxxxxxxxx-30xxxxxxxxxxx-31xxxxxxxxxxx-32xxxxxxxxxxx-33xxxxxxxxxxx-34xxxxxxxxxxx-35xxxxxxxxxxx-36xxxxxxxxxxx-37xxxxxxxxxxx-38xxxxxxxxxxx-39xxxxxxxxxxx-40xxxxxxxxxxx-41xxxxxxxxxxx-42xxxxxxxxxxx-43xxxxxxxxxxx-44xxxxxxxxxxx-45xxxxxxxxxxx-46xxxxxxxxxxx-47xxxxxxxxxxx-48xxxxxxxxxxx-49xxxxxxxxxxx-50xxxxxxxxxxx-51xxxxxxxxxxx-52xxxxxxxxxxx-53xxxxxxxxxxx-54xxxxxxxxxxx-55xxxxxxxxxxx-56xxxxxxxxxxx-57xxxxxxxxxxx-58xxxxxxxxxxx-59xxxxxxxxxxx-60xxxxxxxxxxx-61xxxxxxxxxxx-62xxxxxxxxxxx-63xxxxxxxxxxx-64xxxxxxxxxxx-65xxxxxxxxxxx-66xxxxxxxxxxx-67xxxxxxxxxxx-68xxxxxxxxxxx-69xxxxxxxxxxx-70xxxxxxxxxxx-71xxxxxxxxxxx-72xxxxxxxxxxx-73xxxxxxxxxxx-74xxxxxxxxxxx-75xxxxxxxxxxx-76xxxxxxxxxxx-77xxxxxxxxxxx-78xxxxxxxxxxx-79xxxxxxxxxxx-80xxxxxxxxxxx-81xxxxxxxxxxx-82xxxxxxxxxxx-83xxxxxxxxxxx-84xxxxxxxxxxx-85xxxxxxxxxxx-86xxxxxxxxxxx-87xxxxxxxxxxx-88xxxxxxxxxxx-89xxxxxxxxxxx-90xxxxxxxxxxx-91xxxxxxxxxxx-92xxxxxxxxxxx-93xxxxxxxxxxx-94xxxxxxxxxxx-95xxxxxxxxxxx-96xxxxxxxxxxx-97xxxxxxxxxxx-98xxxxxxxxxxx-99xxxxxxxxxxx-100"
  }
}
