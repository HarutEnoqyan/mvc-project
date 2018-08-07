<?php
require_once ('../autoload.php');
require_once ('../app/helpers.php');
use \Core\ORM;
\Core\Config::init();
\Core\Connection::init();


class Migration extends ORM {

    public function migrate()
    {
        $migrations_dir = BASE_PATH . '/database/migrations';
        global $pdh;

        // check if the migrations table exists

        $sql = "SHOW TABLES LIKE 'migrations'";
        $result = query($sql);
        // if does not exist create the table
        if (count($result)===0) {
            /** @var PDO $pdh */


            $sql = "CREATE TABLE migrations (id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, name varchar(50), date datetime)";
            $success = $pdh->query($sql);
            if (!$success) {
                echo "PDO::errorInfo():";
                print_r($pdh->errorInfo());
                dd($sql);
            }
            echo "Created migrations table successfully \n";
        }


        // if exists get all rows from migrations table

        $sql = "SELECT * FROM migrations";
        $result = $pdh->query($sql);
        $migrated = [];
        if ($result) {
            foreach ($result as $row) {
                $migrated[] = $row['name'];
            }
        }

        $files = scandir($migrations_dir);
        foreach ($files as $file) {
            if (!in_array($file, $migrated) && is_file($migrations_dir . '/' . $file)) {
                $migration_name = pathinfo($file)['filename'] .".sql";
                $sql = file_get_contents($migrations_dir . '/' . $file);
                $success = $pdh->query($sql);
                if ($success) {
                    $success->closeCursor();
                    echo "Migrated " . $migration_name . ' successfully';
                    $sql = "INSERT INTO migrations (name, date) VALUES('$migration_name', NOW())";
                    $success = $pdh->query($sql);
                    if (!$success) {
                        echo "PDO::errorInfo():";
                        print_r($pdh->errorInfo());
                        dd($sql);
                    }
                } else {
                    echo "PDO::errorInfo():";
                    print_r($pdh->errorInfo());
                    dd($sql);
                }
            }
        }
    }

    public function migrateFresh()
    {
        /** @var PDO $pdh */

        global $pdh;
        $sql = "SHOW TABLES";
        $result = $pdh->query($sql);
        if (!$result) {
            echo "PDO::errorInfo():";
            print_r($pdh->errorInfo());
            dd($sql);
        }

        $tables = [];
        foreach (query($sql) as $table){
            $tables[]=$table['Tables_in_mvc_db'];
        }

        foreach ($tables as $table) {
            $sql = " SET FOREIGN_KEY_CHECKS=0 ";
            $result = $pdh->query($sql);
            if(!$result) {
                echo "PDO::errorInfo():";
                print_r($pdh->errorInfo());
                dd($sql);
            }

            $sql = " DROP TABLE $table ";
            $result = $pdh->query($sql);
            if(!$result) {
                echo "PDO::errorInfo():";
                print_r($pdh->errorInfo());
                dd($sql);
            }


        }

        echo "all tables droped successfully \n";

        $this->migrate();
    }

    public function createMigration ()
    {
        /** @var PDO $pdh */

        global $argv;
        global $pdh;
        $patch = date(time());

        if ($argv[2]) {
            if (!file_exists(BASE_PATH .DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$patch.$argv[2].'.sql' )){
                $myFile = fopen(BASE_PATH .DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$patch.$argv[2].'.sql' , 'wb' );
                if ($myFile) {
                    echo "Migration $argv[2] created successfuly:";
                } else {
                    die("something wrong");
                }
            }else {
                die("migration $argv[2] already exists");
            }
        }else {
            die('migration name can\'t be empty');
        };

        $sql = "SHOW TABLES";
        $result = $pdh->query($sql);
        if(!$result) {
            echo "PDO::errorInfo():";
            print_r($pdh->errorInfo());
            dd($pdh);
        }

        if ($result) {
            foreach (query($sql) as $table){
                if($table['Tables_in_mvc_db']=='migrations') {
                    die();
                };
            }
        }


        $sql = "CREATE TABLE migrations(id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT , name VARCHAR(255) NOT NULL , date DATETIME)";
        $result = $pdh->query($sql);
        if(!$result) {
            echo "PDO::errorInfo():";
            print_r($pdh->errorInfo());
            dd($sql);
        }

    }


}

$a = new Migration();
if ($argv) {
    $methot_name = $argv[1];

    if (method_exists($a,$methot_name)){
        $a->$methot_name();
    }else {
        echo "method $argv[1] dosen't exists";
    }
}



