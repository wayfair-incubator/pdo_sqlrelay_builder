<?php // -*-  Mode: php -*-

$host = getenv("SQLRELAY_SERVER_HOST");
$port = getenv("SQLRELAY_SERVER_PORT");
$user = getenv("SQLRELAY_SERVER_USER");
$pass = getenv("SQLRELAY_SERVER_PASS");
$connect_timeout = getenv("SQLRELAY_CONNECT_TIMEOUT");
$sqlr_client_debug_prefix = getenv("SQLR_CLIENT_DEBUG_PREFIX");
$fetchlobsasstrings = getenv("SQLRELAY_FETCH_LOB_AS_STRING");
$hide_type_lob = getenv("SQLRELAY_HIDE_TYPE_LOB");

if (($fetchlobsasstrings === false) || $fetchlobsasstrings === "") {
    $fetchlobsasstrings = "1";
}

if (($hide_type_lob === false) || $hide_type_lob === "") {
    $hide_type_lob = true;
} else {
    $hide_type_lob = boolval(intval($hide_type_lob));
}

$hostname = gethostname();

$env_defaults_file = getenv("ENV_DEFAULTS_FILE");

if (empty($env_defaults_file)) {
    $env_defaults_file = "makefile.dev.ini";
}

if (file_exists($env_defaults_file)) {
    $env_defaults_array_ini = parse_ini_file($env_defaults_file, true, INI_SCANNER_TYPED);
} else {
    $env_defaults_array_ini = [];
}

$env_defaults_array = $env_defaults_array_ini['global'] ?? [];

if (!empty($env_defaults_array['sde_hostname_pattern'])) {
    $sde_hostname_pattern = $env_defaults_array['sde_hostname_pattern'];
    if (preg_match($sde_hostname_pattern, $hostname) === 1) {
        $env_defaults_array = $env_defaults_array_ini['sde'];
    }
}

if (empty($user)) {
    $user = $env_defaults_array['SQLRELAY_SERVER_USER'] ?? 'sa';
}
if (empty($pass)) {
    $pass = base64_decode($env_defaults_array['SQLRELAY_SERVER_PASS'] ?? 'bWFuYWdlcg==');
}
if (empty($host)) {
    $host = $env_defaults_array['SQLRELAY_SERVER_HOST'] ?? 'localhost';
}
if (empty($port)) {
    $port = $env_defaults_array['SQLRELAY_SERVER_PORT'] ?? 9000;
}

if (empty($connect_timeout)) {
    $connect_timeout = $env_defaults_array['SQLRELAY_CONNECT_TIMEOUT'] ?? 60;
}

$client_file = __FILE__;

if (function_exists('debug_backtrace')) {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
    if (is_array($backtrace) && count($backtrace) > 0 && array_key_exists('file', $backtrace[0]))
        $client_file = $backtrace[0]['file'];
}

$client_basename = basename($client_file, ".php");

$debug_option = "0";

if (!empty($sqlr_client_debug_prefix)) {
    $debug_option = $sqlr_client_debug_prefix . $client_basename . ".sqlrelay.log";
}

$connect_options = implode(
    ";",
    [
        "nullsasnulls=1",
        "lazyconnect=0",
        "debug=$debug_option",
        "autocommit=1",
        "fetchlobsasstrings=$fetchlobsasstrings",
        "connecttime=$connect_timeout",
    ]
);

$connect_string = "sqlrelay:host=$host;port=$port;$connect_options";
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
];

function get_desc_type($obj) {
  $desc_type = gettype($obj);
  if ($desc_type == "object") {
    return get_class($obj);
  } else {
    return $desc_type;
  }
}

$t0 = microtime(true);
try {
    $pdo = new \PDO($connect_string, $user, $pass, $pdo_options);
    $t1 = microtime(true);
} catch (Throwable $e) {
    $t1 = microtime(true);
    // it is useful to provide a detailed message about
    // the connection error encountered during testing,
    // so that any infrastructure problems can be more easily fixed.
    // This includes data which can vary by the environment.
    $info = [
        'connection_string' => $connect_string,
        'error_type' => get_desc_type($e),
        'error_message' => $e->getMessage(),
        'elapsed_time' => round($t1 - $t0, 6),
    ];
    $previous = $e->getPrevious();
    if ($previous != null) {
        $info['previous'] = [
            'error_type' => get_desc_type($previous),
            'error_message' => $previous->getMessage(),
        ];
    }
    var_dump($info);
}

var_dump(get_desc_type($pdo));

// for debugging issues with stuck tests etc, as some of the tests
// will involve simulated networking issues, it is very useful for
// a general usage sqlrelay proxy to be able to easily see
// what is being run against it, and clientinfo is perfect
// for that, and used extensively in debugging involving
// the PHP Monolith.

$sqlrelay_client_info = strval(getmypid()) . '|' . $hostname . '|' . $client_basename;

$pdo->setAttribute(PDO::SQLRELAY_ATTR_CLIENT_INFO, $sqlrelay_client_info);

$pdo_type_name_map = [
    PDO::PARAM_NULL => "PARAM_NULL",
    PDO::PARAM_INT => "PARAM_INT",
    PDO::PARAM_STR => "PARAM_STR",
    PDO::PARAM_LOB => "PARAM_LOB",
    PDO::PARAM_STMT => "PARAM_STMT",
    PDO::PARAM_BOOL => "PARAM_BOOL",
];

function test_query($pdo, $sql, ...$bindings) {
    global $pdo_type_name_map;
    global $hide_type_lob;
    $statement = $pdo->prepare($sql);
    var_dump(get_desc_type($statement));
    $n = count($bindings);
    for ($j = 0; $j < $n; $j += 3) {
        var_dump($statement->bindValue($bindings[$j], $bindings[$j + 2], $bindings[$j + 1]));
    }
    var_dump($statement->execute());
    var_dump($statement->errorInfo());
    $column_count = $statement->columnCount();
    $meta_list = [];
    for ($i = 0; $i < $column_count; $i++) {
        $meta = $statement->getColumnMeta($i);
        // there is a bug in the meta with these types, with these
        // attributes returning a value from some uninitialized
        // memory area, presumably, a value that is different every time.
        if (in_array($meta["native_type"] , ["LONGVARBINARY", "LONGVARCHAR", "NTEXT"])) {
            $meta["len"] = "REDACTED";
            $meta["precision"] = "REDACTED";
        }
        if (array_key_exists('pdo_type', $meta)) {
            $pdo_type = $meta['pdo_type'] & 0xFF; // not sure of the mask, close enough.
            if (($pdo_type === PDO::PARAM_LOB) &&
                ($hide_type_lob)
            ) {
                $meta['pdo_type'] = $pdo_type = PDO::PARAM_STR;
            }
            if (array_key_exists($pdo_type, $pdo_type_name_map)) {
                $meta['pdo_type_name'] = $pdo_type_name_map[$pdo_type];
            }
        }
        $meta_list[] = $meta;
    }
    var_dump(['column_count' => $column_count, 'meta' => $meta_list]);
    $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    // resolve resource returns into strings.
    if (!empty($resultset)) {
        $n = count($resultset);
        for($j = 0; $j < $n; ++$j) {
            $row = $resultset[$j];
            $keys = array_keys($row);
            foreach($keys as $key) {
                $value = $row[$key];
                if (is_resource($value)) {
                    $string_value = stream_get_contents($value);
                    // depending on column meta we could base64_encode this.
                    $resultset[$j][$key] = $string_value;
                }
            }
        }
    }
    var_dump($resultset);
}
