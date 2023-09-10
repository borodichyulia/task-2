<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '4747Smth4747');
define('DB_NAME', 'task-2');
define('DB_TABLE_VERSIONS', 'versions');


function connectDB()
{
    $errorMessage = 'Unable to connect to database server';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn)
        throw new Exception($errorMessage);
    else {
        $query = $conn->query('set names utf8');
        if (!$query)
            throw new Exception($errorMessage);
        else
            return $conn;
    }
}


function getMigrationFiles($conn)
{
    $sqlFolder = "D:/innowise/tasks/julia.borodich/tasks/task/database/migrations/";

    $allFiles = glob($sqlFolder . '*.sql');

    $query = sprintf('show tables from `%s` like "%s"', DB_NAME, DB_TABLE_VERSIONS);
    $data = $conn->query($query);
    $firstMigration = !$data->num_rows;

    if ($firstMigration) {
        return $allFiles;
    }

    $versionsFiles = array();

    $query = sprintf('select `name` from `%s`', DB_TABLE_VERSIONS);
    $data = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

    foreach ($data as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }

    return array_diff($allFiles, $versionsFiles);
}


function migrate($conn, $file)
{
    $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', DB_USER, DB_PASSWORD, DB_HOST, DB_NAME, $file);

    shell_exec($command);

    $baseName = basename($file);

    $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $baseName);
    $conn->query($query);
}



$conn = connectDB();

$files = getMigrationFiles($conn);

if (empty($files)) {
    echo 'Your database is up to date';
} else {
    echo 'Starting the migration<br /><br />';

    foreach ($files as $file) {
        migrate($conn, $file);
        echo basename($file) . '<br />';
    }

    echo '<br />Migration completed';
}
