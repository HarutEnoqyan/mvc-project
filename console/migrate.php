<?php

$migrations_dir = APP_PATH . '/database/migrations';

require_once(APP_PATH . '/core/config.php');
require_once(APP_PATH . '/core/database.php');

$sql = "SHOW TABLES LIKE 'migrations'";
$result = mysqli_query($connection, $sql);
if (!$result->num_rows) {
	$sql = "CREATE TABLE migrations (id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, name varchar(50), date datetime)";
	$success = mysqli_query($connection, $sql);
	if (!$success) {
		echo "Could not create migrations table. Aborting \n";
		echo "Error: " . mysqli_error($connection);
		die();
	}
	echo "Created migrations table successfully \n";
}

$sql = "SELECT * FROM migrations";
$result = mysqli_query($connection, $sql);
$migrated = [];
if ($result->num_rows) {
	foreach ($result as $row) {
		$migrated[] = $row['name'];
	}
}

// check if the migrations table exists

// if does not exist create the table

// if exists get all rows from migrations table

$files = scandir($migrations_dir);

foreach ($files as $file) {
	if (is_file($migrations_dir . '/' . $file)) {
		$migration_name = pathinfo($file)['filename'];
		if (!in_array($migration_name, $migrated)) {
			$sql = file_get_contents($migrations_dir . '/' . $file);
			$success = mysqli_query($connection, $sql);
			if ($success) {
				echo "Migrated " . $migration_name . ' successfully';
				$sql = "INSERT INTO migrations (name, date) VALUES('$migration_name', NOW())";
				mysqli_query($connection, $sql);
			} else {
				echo "Migration " . $migration_name . ' failed. Reason: ';
				echo mysqli_error($connection);
				die();
			}
		}
	}
}