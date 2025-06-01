<?php
// File: pg_backup.php
// Purpose: backup postgres
// Date: 02 Dec 2000
// Author: Dan Wilson

$data_dir = "/opt/lampp/htdocs/procesadora/backup/data";
echo $data_dir;
// $pg_dump_dir = "/usr/bin";
$pg_dump_dir = "/opt/PostgreSQL/9.3/bin";
$keep = (60 * 60 * 24) * 30; // 30 days

$dbname[] = "asproc_nbt";

$dump_date = date("Ymd_Hs");

$file_name = $data_dir . "/dump_" . $dump_date . ".sql";

// echo date("Y-m-d H:i:s T"), "\n";
if ($cntDB = count($dbname)) {
for ($iDB = 0; $iDB < $cntDB; $iDB++) {
system("$pg_dump_dir/pg_dump $dbname[$iDB] >> $file_name");
}
} else {
system("$pg_dump_dir/pg_dumpall > $file_name");
}

// echo date("Y-m-d H:i:s T"), "\n";

$dirh = dir($data_dir);
while($entry = $dirh->read()) {
$old_file_time = (date("U") - $keep);
$file_created = filectime("$data_dir/$entry");
if ($file_created < $old_file_time && !is_dir($entry)) {
if(unlink("$data_dir/$entry")) {
// echo "Delete $data_dir/$entry\n";
}
}
}

?>