<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Router;

class ParameterRoute {
    private $parameters = [];

    public $parameterValues = [];

    public function __construct($uri)
    {
        $tokens = explode('/', $uri);
        foreach ($tokens as $token) {
            if ($token[0] == '{') {
                $parameterComponents = preg_split('/[\s+\{\}]/', $token, -1, PREG_SPLIT_NO_EMPTY);
                switch ($parameterComponents[0]) {
                    case 'int':
                        $parameter = new UriParameter(UriParameter::INTEGER_TYPE, $parameterComponents[1]);
                        $this->parameters[] = $parameter;
                        break;
                    case 'string':
                        $parameter = new UriParameter(UriParameter::STRING_TYPE, $parameterComponents[1]);
                        $this->parameters[] = $parameter;
                        break;
                    case 'double':
                        $parameter = new UriParameter(UriParameter::DOUBLE_TYPE, $parameterComponents[1]);
                        $this->parameters[] = $parameter;
                        break;
                    case 'boolean':
                        $parameter = new UriParameter(UriParameter::BOOLEAN_TYPE, $parameterComponents[1]);
                        $this->parameters[] = $parameter;
                        break;
                    default:
                        throw new \Exception('Invalid parameter type.');
                }
            } else {
                $this->parameters[] = $token;
            }
        }
    }

    public function isMatching($route) : bool
    {
        $components = explode('/', $route);
        if (count($components) != count($this->parameters)) {
            return false;
        }

        for ($i = 0; $i < count($this->parameters); $i++) {
            if (gettype($this->parameters[$i]) == 'object') {
                $this->parameterValues[] = $components[$i];
                if (!$this->parameters[$i]->isValid($components[$i])) {
                    return false;
                }
            } else {
                if ($this->parameters[$i] != $components[$i]) {
                    return false;
                }
            }
        }

        return true;
    }
}


class UriParameter {
    private $type;
    private $name;

    const INTEGER_TYPE = 1;
    const STRING_TYPE = 2;
    const BOOLEAN_TYPE = 3;
    const DOUBLE_TYPE = 4;

    public function __construct($type, $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(int $type)
    {
        if ($type < 1 || $type > 4) {
            throw new \Exception('Type must be a valid integer number.');
        }
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function isValid($value) : bool
    {
        switch ($this->type) {
            case self::DOUBLE_TYPE:
                if (floatval($value) === 0) {
                    return false;
                } else {
                    return true;
                }
                break;
            case self::BOOLEAN_TYPE:
                if ($value == '1' || $value == '0' || $value == 'true' || $value == 'false') {
                    return true;
                } else {
                    return false;
                }
                break;
            case self::INTEGER_TYPE:
                if (intval($value) === 0) {
                    return false;
                } else {
                    return true;
                }
                break;
            case self::STRING_TYPE:
                return true;
                break;
            default :
                return false;
                break;
        }
    }
}