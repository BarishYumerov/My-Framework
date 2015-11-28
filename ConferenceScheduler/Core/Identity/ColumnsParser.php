<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Identity;


class ColumnsParser
{
    private $columns = [];

    public function hasColumn($columnName) : bool
    {
        return array_key_exists($columnName, $this->columns);
    }

    public function getColumnType($columnName)
    {
        if (array_key_exists($columnName, $this->columns)) {
            return $this->columns[$columnName];
        } else {
            return null;
        }
    }

    public function setColumn($columnName, $columnValue)
    {
        $this->columns[$columnName] = $columnValue;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function equals($anotherUserTable) : bool
    {
        foreach ($this->columns as $key => $value) {
            if (!$anotherUserTable->hasColumn($key)) {
                return false;
            } else {
                if ($value !== $anotherUserTable->getColumnType($key)) {
                    return false;
                }
            }
        }

        return true;
    }
}