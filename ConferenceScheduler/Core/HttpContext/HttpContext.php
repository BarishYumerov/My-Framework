<?php

namespace ConferenceScheduler\Core\HttpContext;

use ConferenceScheduler\Core\Commons\Normalizer;

class HttpContext {
    private static $_instance = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();
    private $_session = array();
    private $method = 'get';

    private function __construct() {
        $this->setGet($_GET);
        $this->setPost($_POST);
        $this->setCookies($_COOKIE);
        $this->setSession($_SESSION);
        $this->setMethod(strtolower($_SERVER['REQUEST_METHOD']));
    }

    public function setPost($ar) {
        if (is_array($ar)) {
            $this->_post = $ar;
        }
    }

    public function setGet($ar) {
        if (is_array($ar)) {
            $this->_get = $ar;
        }
    }

    public function setCookies($ar) {
        if (is_array($ar)) {
            $this->_cookies = $ar;
        }
    }

    public function setSession($ar) {
        if (is_array($ar)) {
            $this->_session = $ar;
        }
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function hasGet($id) {
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name) {
        return array_key_exists($name, $this->_post);
    }

    public function hasSession($name) {
        return array_key_exists($name, $this->_session);
    }

    public function hasCookies($name) {
        return array_key_exists($name, $this->_cookies);
    }

    public function get($id, $normalize = null, $default = null) {
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return Normalizer::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }
        return $default;
    }

    public function post($name, $normalize = null, $default = null) {
        if ($this->hasPost($name)) {
            if ($normalize != null) {
                return Normalizer::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }
        return $default;
    }

    public function cookies($name, $normalize = null, $default = null) {
        if ($this->hasCookies($name)) {
            if ($normalize != null) {
                return Normalizer::normalize($this->_cookies[$name], $normalize);
            }
            return $this->_cookies[$name];
        }
        return $default;
    }

    public function session($name, $normalize = null, $default = null) {
        if ($this->hasSession($name)) {
            if ($normalize != null) {
                return Normalizer::normalize($this->_session[$name], $normalize);
            }
            return $this->_session[$name];
        }
        return $default;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function isGet()
    {
        return $this->method == 'get';
    }

    public function isPost()
    {
        return $this->method == 'post';
    }

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new HttpContext();
        }
        return self::$_instance;
    }

    public function addSessionItem($key, $value){
        $this->_session[$key] = $value;
    }

    public function addCookieItem($key, $value){
        $this->_cookies[$key] = $value;
    }

    public function addGetItem($key, $value){
        $this->_get[$key] = $value;
    }

    public function addPostItem($key, $value){
        $this->_post[$key] = $value;
    }
}