--TEST--
pdo_test.php --test some transaction features.
--SKIPIF--
<?php if(!extension_loaded('pdo_sqlrelay')) die('skip '); ?>
--FILE--
<?php

include __DIR__ . '/query_functions.php.inc';

$sql_with_balanced_transaction = <<<GO
-- This comment keeps the sqlrelay server from
-- doing a sniff to find the T-SQL for transactions.
DECLARE @T1 INT
DECLARE @T2 INT
DECLARE @T3 INT
SET @T1 = @@TRANCOUNT
BEGIN TRANSACTION
SET @T2 = @@TRANCOUNT
ROLLBACK
SET @T3 = @@TRANCOUNT
SELECT @T1 AS T1,@T2 AS T2,@T3 AS T3
GO;

$sql_trancount = <<<GO
SELECT @@TRANCOUNT AS T1
GO;

test_query($pdo, $sql_trancount);
test_query($pdo, $sql_with_balanced_transaction);
test_query($pdo, $sql_trancount);
var_dump($pdo->beginTransaction());
test_query($pdo, $sql_trancount);
var_dump($pdo->rollBack());
test_query($pdo, $sql_trancount);

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
  int(1)
  ["meta"]=>
  array(1) {
    [0]=>
    array(7) {
      ["native_type"]=>
      string(7) "INTEGER"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(0) {
      }
      ["name"]=>
      string(2) "T1"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
  }
}
array(1) {
  [0]=>
  array(1) {
    ["T1"]=>
    int(0)
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
  int(3)
  ["meta"]=>
  array(3) {
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
      string(2) "T1"
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
      string(7) "INTEGER"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(1) {
        [0]=>
        string(8) "nullable"
      }
      ["name"]=>
      string(2) "T2"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
    [2]=>
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
      string(2) "T3"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
  }
}
array(1) {
  [0]=>
  array(3) {
    ["T1"]=>
    int(0)
    ["T2"]=>
    int(1)
    ["T3"]=>
    int(0)
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
  int(1)
  ["meta"]=>
  array(1) {
    [0]=>
    array(7) {
      ["native_type"]=>
      string(7) "INTEGER"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(0) {
      }
      ["name"]=>
      string(2) "T1"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
  }
}
array(1) {
  [0]=>
  array(1) {
    ["T1"]=>
    int(0)
  }
}
bool(true)
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
  int(1)
  ["meta"]=>
  array(1) {
    [0]=>
    array(7) {
      ["native_type"]=>
      string(7) "INTEGER"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(0) {
      }
      ["name"]=>
      string(2) "T1"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
  }
}
array(1) {
  [0]=>
  array(1) {
    ["T1"]=>
    int(1)
  }
}
bool(true)
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
  int(1)
  ["meta"]=>
  array(1) {
    [0]=>
    array(7) {
      ["native_type"]=>
      string(7) "INTEGER"
      ["pdo_type"]=>
      int(1)
      ["flags"]=>
      array(0) {
      }
      ["name"]=>
      string(2) "T1"
      ["len"]=>
      int(10)
      ["precision"]=>
      int(10)
      ["pdo_type_name"]=>
      string(9) "PARAM_INT"
    }
  }
}
array(1) {
  [0]=>
  array(1) {
    ["T1"]=>
    int(0)
  }
}
