<?php

namespace ConferenceScheduler\Core\ORM;

use PDO;
use ConferenceScheduler\Configs\DatabaseConfig;

class Orm {

    public static function update()
    {
        $connectionString = DatabaseConfig::DB_DRIVER . ":host=" . DatabaseConfig::DB_HOST . ";dbname=" .
            DatabaseConfig::DB_NAME;
        $pdo = new PDO($connectionString, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASS);

        self::removeOldFiles();

        $tables= array_map(function($t) { return $t[0]; },
            $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_NUM));

        foreach ($tables as $tableName) {
            $columns =
                array_map(function($c) { return $c['Field']; },
                    $pdo->query("SHOW COLUMNS FROM $tableName")->fetchAll(PDO::FETCH_ASSOC));

            $repositoryName = $tableName;

            $model = $repositoryName[strlen($repositoryName) - 1] == 's' ? substr($repositoryName, 0, strlen($repositoryName) - 1) : $repositoryName;

            $repositoryName .= "Repository";

            $model = ucfirst($model);

            Repositories::create($repositoryName, $model, $tableName, $columns);
            $output = "";
            $output .= self::generateClassInfo($model);
            $output .= self::generateConstants($model, $tableName, $columns);
            $output .= self::generateFields($model, $tableName, $columns);
            $output .= self::generateConstructor($model, $tableName, $columns);
            $output .= self::generateGettersAndSetters($model, $tableName, $columns);
            $output .= "}";
            $modelFile = fopen("Models/" . $model . '.php', 'w');
            fwrite($modelFile, $output);

            $collectionsOutput = Collections::create($model);
            $collectionFile = fopen('Collections/' . $model . 'Collection.php', 'w');
            fwrite($collectionFile, $collectionsOutput);

            EntityCreator::create();
        }
    }

    private static function generateClassInfo($model) {
        $output = <<<KUF
<?php

namespace ConferenceScheduler\Models;

class $model
{
KUF;

        return $output;
    }

    private static function generateFields($model, $tableName, $columns) {
        $output = "";
        foreach ($columns as $column) {
            $output .= "\n\tprivate $" . $column . ';';
        }

        return $output . "\n";
    }

    private static function generateConstructor($model, $tableName, $columns) {
        $output = "";
        $signature = "";
        foreach ($columns as $column) {
            if ($column != "id") {
                $signature .= '$' . $column . ", ";
            }
        }
        $signature .='$id = null';
        $output .="\n\tpublic function __construct($signature)";
        $output .="\n\t{";
        foreach ($columns as $column) {
            $output .="\n\t\t" . '$this->set' . ucfirst($column) . '($' . $column . ');';
        }
        $output .="\n\t}";

        return $output . "\n";
    }

    private static function generateGettersAndSetters($model, $tableName, $columns) {
        /*
         *     /**
             * @return mixed

            public function getId()
            {
                return $this->id;
            }
         */
        $output = "";
        foreach ($columns as $column) {
            $output .="\n\t/**";
            $output .= "\n\t* @return mixed";
            $output .= "\n\t*/";
            $output .= "\n\tpublic function get" . ucfirst($column) . '()';
            $output .= "\n\t{";
            $output .= "\n\t\treturn" .' $this->' . $column . ';';
            $output .= "\n\t}";
            $output .= "\n";
            $output .="\n\t/**";
            $output .= "\n\t* @param" . ' $' . $column;
            $output .= "\n\t* @return" . ' $this';
            $output .= "\n\t*/";
            $output .= "\n\tpublic function set" . ucfirst($column) . '($'.$column.')';
            $output .= "\n\t{";
            $output .= "\n\t\t" .'$this->' . $column . ' = $' . $column. ';';
            $output .= "\n\t\t";
            $output .= "\n\t\treturn" .' $this;';
            $output .= "\n\t}";
            $output .= "\n\n";
        }

        return $output;
    }

    private static function generateConstants($model, $tableName, $columns) {
        //    const COL_USERNAME = 'username';
        $output = "";
        foreach ($columns as $column) {
            $output .= "\n\tconst COL_" . strtoupper($column) . ' = \'' . $column . '\';';
        }
        return $output . "\n";
    }

    private static function removeOldFiles()
    {
        $files = glob('Models/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }

        $files = glob('Repositories/*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }

        $files = glob('Collections/*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }
    }
}