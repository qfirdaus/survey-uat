<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dsn  = "dsn_sybase_student_dev";      // Nama DSN ODBC
$user = "dba_student";      // Username Sybase
$pass = "mnpu123";      // Password Sybase

$conn = odbc_connect($dsn, $user, $pass);

$sql = "SELECT COUNT(*) AS total FROM survey_login";

$rs = odbc_exec($conn, $sql);

$row = odbc_fetch_array($rs);

echo "Jumlah rekod : ".$row['total'];

if (!$conn) {
    die("<h3>Connection Failed</h3>" . odbc_errormsg());
}

echo "<h3 style='color:green'>Connected to Sybase via ODBC</h3>";

$sql = "SELECT TOP 5 username, password
        FROM survey_login";

$rs = odbc_exec($conn, $sql);

if (!$rs) {
    die("<h3>Query Error</h3>" . odbc_errormsg($conn));
}

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Username</th><th>Password</th></tr>";

while ($row = odbc_fetch_array($rs)) {
    echo "<tr>";
    echo "<td>{$row['username']}</td>";
    echo "<td>{$row['password']}</td>";
    echo "</tr>";
}

echo "</table>";

odbc_close($conn);