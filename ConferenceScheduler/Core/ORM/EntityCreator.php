<?php

namespace ConferenceScheduler\Core\ORM;

class EntityCreator {
    public static function create()
    {
        $repositoryNames =  self::getRepositoryNames();
        $privateRepositoryFields = "";
        foreach ($repositoryNames as $name) {
            $privateRepositoryFields .= "\tprivate $" . $name . ";\n";
        }
        $privateRepositoryFields = ltrim($privateRepositoryFields, "\t");
        $privateRepositoryFields = rtrim($privateRepositoryFields, "\n");

        $constructorParametersList = '';
//        foreach ($repositoryNames as $name) {
//            $constructorParametersList .= "$$name" . ", ";
//        }
//        $constructorParametersList = rtrim($constructorParametersList, ", ");

        $settingPrivateRepositoryFields = '';
        foreach ($repositoryNames as $name) {
            $repoClassName = ucfirst($name);
            $settingPrivateRepositoryFields .= "\t\t\$this->$name = \ConferenceScheduler\Repositories\\$repoClassName::create();\n";
        }
        $settingPrivateRepositoryFields = ltrim($settingPrivateRepositoryFields, "\t");
        $settingPrivateRepositoryFields = rtrim($settingPrivateRepositoryFields, "\n");

        $addRepositoriesToInternalCollection = '';
        foreach ($repositoryNames as $name) {
            $addRepositoriesToInternalCollection .= "\t\t\$this->repositories[] = \$this->$name;\n";
        }
        $addRepositoriesToInternalCollection = ltrim($addRepositoriesToInternalCollection, "\t");
        $addRepositoriesToInternalCollection = rtrim($addRepositoriesToInternalCollection, "\n");

        $repositoryGetters = '';
        foreach ($repositoryNames as $name) {
            $repoName = ucfirst($name);
            $repositoryGetters .= <<<KUF
    /**
     * @return \ConferenceScheduler\Repositories\\$repoName
     */
    public function get$repoName()
    {
        return \$this->$name;
    }
KUF;
            $repositoryGetters .= "\n\n";
        }
        $repositoryGetters = ltrim($repositoryGetters, "\t");
        $repositoryGetters = rtrim($repositoryGetters, "\n");

        $repositorySetters = '';
        foreach ($repositoryNames as $name) {
            $repoName = ucfirst($name);
            $repositorySetters .= <<<KUF
    /**
     * @param mixed $$name
     * @return \$this
     */
    public function set$repoName($$name)
    {
        \$this->$name = $$name;
        return \$this;
    }
KUF;
            $repositorySetters .= "\n\n";
        }
        $repositorySetters = ltrim($repositorySetters, "\t");
        $repositorySetters = rtrim($repositorySetters, "\n");

        $contents = file_get_contents('Core' . DIRECTORY_SEPARATOR .
            'ORM' . DIRECTORY_SEPARATOR .
            'DbContestTemplate.txt');

        $contents = str_replace("{{privateRepositoryFields}}", $privateRepositoryFields, $contents);
        $contents = str_replace("{{constructorParametersList}}", $constructorParametersList, $contents);
        $contents = str_replace("{{settingPrivateRepositoryFields}}", $settingPrivateRepositoryFields, $contents);
        $contents = str_replace("{{addRepositoriesToInternalCollection}}", $addRepositoriesToInternalCollection, $contents);
        $contents = str_replace("{{repositoryGetters}}", $repositoryGetters, $contents);
        $contents = str_replace("{{repositorySetters}}", $repositorySetters, $contents);

        $databaseContextFile = fopen('Core' . DIRECTORY_SEPARATOR .
            'ORM' . DIRECTORY_SEPARATOR .
            'DbContext.php'
            , 'w');
        fwrite($databaseContextFile, $contents);
    }

    public static function getRepositoryNames()
    {
        $names = [];

        $dirHandle = opendir('Repositories');
        $file = readdir($dirHandle);

        while ($file) {
            if ($file[0] == '.') {
                $file = readdir($dirHandle);
                continue;
            }

            $names[] = lcfirst(substr($file, 0, strlen($file) - 4));
            $file = readdir($dirHandle);
        }

        return $names;
    }
}