<?php

namespace ConferenceScheduler\Core\ORM;

/**
 * The skeleton of the code is taken from RoYal
 */
class Collections {

    public static function create($model)
    {
        $modelCollection = $model . 'Collection';
        $modelName = $model . 's';
        $modelArray = $model . '[]';
        return <<<KUF
<?php

namespace ConferenceScheduler\Collections;

use ConferenceScheduler\Models\\$model;

class $modelCollection
{
    /**
     * @var $modelArray;
     */
    private \$collection = [];

    public function __construct(\$models = [])
    {
        \$this->collection = \$models;
    }

    /**
     * @return $modelArray
     */
    public function get$modelName()
    {
        return \$this->collection;
    }

    /**
     * @param callable \$callback
     */
    public function each(Callable \$callback)
    {
        foreach (\$this->collection as \$model) {
            \$callback(\$model);
        }
    }
}
KUF;
    }
}