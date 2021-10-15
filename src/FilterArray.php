<?php

/**
 * FilterArray class
 *
 *
 * @author Qexy admin@qexy.org
 *
 * @copyright © 2021 Alonity
 *
 * @package alonity\filter
 *
 * @license MIT
 *
 * @version 1.0.0
 *
 */

namespace alonity\filter;

class FilterArray {
    private $keys, $method, $regexp, $type, $input, $default, $compiled;

    /**
     * @param array $keys
     *
     * @param int $method
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param string $default
     *
     * @param array $input
     *
    */
    public function __construct(array $keys, int $method = Filters::GET, ?string $regexp = null, int $type = 0, $default = '', array $input = []) {

        $this->setKeys($keys)
            ->setRegExp($regexp)
            ->setType($type)
            ->setInput($input)
            ->setDefault($default)
            ->setMethod($method);
    }



    /**
     * Setter for keys
     *
     * @param array $keys
     *
     * @return self
    */
    public function setKeys(array $keys) : self {
        $this->keys = $keys;

        return $this;
    }

    /**
     * Getter for keys
     *
     * @return array
    */
    public function getKeys() : array {
        return $this->keys;
    }



    /**
     * Setter for default method
     *
     * @param int $method
     *
     * @return self
    */
    public function setMethod(int $method) : self {
        $this->method = $method;

        return $this;
    }

    /**
     * Getter for default method
     *
     * @return int
    */
    public function getMethod() : int {
        return $this->method;
    }



    /**
     * Setter for default value
     *
     * @param mixed $value
     *
     * @return self
    */
    public function setDefault($value) : self {
        $this->default = $value;

        return $this;
    }

    /**
     * Getter for default value
     *
     * @return mixed
    */
    public function getDefault() {
        return $this->default;
    }

    public function setInput($input) : self {
        $this->input = $input;

        return $this;
    }

    public function getInput() {
        return $this->input;
    }



    /**
     * Setter for default type
     *
     * @param int $type
     *
     * @return self
     */
    public function setType(int $type) : self {
        $this->type = $type;

        return $this;
    }

    /**
     * Getter for default type
     *
     * @return int
     */
    public function getType() : int {
        return $this->type;
    }



    /**
     * Setter for default regular expression
     *
     * @param string|null $regexp
     *
     * @return self
     */
    public function setRegExp(?string $regexp) : self {
        $this->regexp = $regexp;

        return $this;
    }

    /**
     * Getter for default regular expression
     *
     * @return string | null
     */
    public function getRegExp() : ?string {
        return $this->regexp;
    }



    /**
     * @param string|null $key
     *
     * @return Filter[] | Filter | null
    */
    public function get(?string $key = null) {
        if(is_null($this->compiled)){
            $this->execute();
        }

        if(!is_null($key)){
            return $this->compiled[$key] ?? null;
        }

        return $this->compiled;
    }



    /**
     * Filter executor
     *
     * @return self
    */
    public function execute() : self {

        $this->compiled = [];

        foreach($this->getKeys() as $k => $v){

            if($v instanceof Filter){
                $key = $v->getKey();

                $this->compiled[$key] = $v;
            }elseif(is_array($v) && is_string($k)){
                $key = $k;

                $regexp = $v['regexp'] ?? $this->getRegExp();

                $type = $v['type'] ?? $this->getType();

                $default = $v['default'] ?? $this->getDefault();

                $method = $v['method'] ?? $this->getMethod();

                $input = $v['input'] ?? $this->getInput();

                $maxLength = $v['maxLength'] ?? null;

                $min = $v['min'] ?? null;

                $max = $v['input'] ?? null;

                $trim = $v['input'] ?? null;

                $maxDeep = $v['maxDeep'] ?? null;

                $this->compiled[$k] = Filters::method($method, $k, $regexp, $type, $default, $input)->setMaxLength($maxLength)->setMin($min)->setMax($max)->setTrim($trim)->setMaxDeep($maxDeep);
            }else{
                $key = $v;

                $this->compiled[$v] = Filters::method($this->getMethod(), $v, $this->getRegExp(), $this->getType(), $this->getDefault(), $this->getInput());
            }


            $this->compiled[$key]->execute();
        }

        return $this;
    }
}