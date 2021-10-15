<?php

/**
 * Filter class
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

class Filter {
    const VERSION = '1.0.0';

    private $regexp;

    private $value;

    private $compiled;

    private $trim = true;

    private $type = 0;

    private $max, $min, $maxDeep, $maxLength, $key;

    public function __construct(string $value, ?string $regexp = null, int $type = 0, ?string $key = null){
        $this->setValue($value)
            ->setRegExp($regexp)
            ->setKey($key)
            ->setType($type);
    }



    /**
     * Setter for input value
     *
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value) : self {
        $this->value = $value;

        return $this;
    }

    /**
     * Getter for input value
     *
     * @return mixed
     */
    public function getValue() : string {
        return $this->value;
    }



    /**
     * Setter for input type
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
     * Getter for input type
     *
     * @return int
     */
    public function getType() : int {
        return $this->type;
    }



    /**
     * Setter for input key
     *
     * @param string | null $key
     *
     * @return self
     */
    public function setKey(?string $key) : self {
        $this->key = $key;

        return $this;
    }

    /**
     * Getter for input key
     *
     * @return string | null
     */
    public function getKey() : ?string {
        return $this->key;
    }



    /**
     * Setter for regexp value
     *
     * @param string | null $regexp
     *
     * @return self
     */
    public function setRegExp(?string $regexp) : self {
        $this->regexp = $regexp;

        return $this;
    }

    /**
     * Getter for regexp value
     *
     * @return string | null
     */
    public function getRegExp() : ?string {
        return $this->regexp;
    }



    /**
     * Setter for trim value
     *
     * @param bool $value
     *
     * @return self
     */
    public function setTrim(bool $value) : self {
        $this->trim = $value;

        return $this;
    }

    /**
     * Getter for trim value
     *
     * @return bool
     */
    public function getTrim() : bool {
        return $this->trim;
    }



    /**
     * Setter for maximum deep array
     *
     * @param int | null $value
     *
     * @return self
     */
    public function setMaxDeep(?int $value) : self {
        $this->maxDeep = $value < 1 ? 1 : $value;

        return $this;
    }

    /**
     * Getter for maximum deep array
     *
     * @return int | null
     */
    public function getMaxDeep() : ?int {
        return $this->maxDeep;
    }



    /**
     * Setter for minimum value
     *
     * @param float | null $value
     *
     * @return self
     */
    public function setMin(?float $value) : self {
        $this->min = $value;

        return $this;
    }

    /**
     * Getter for minimum value
     *
     * @return float | null
     */
    public function getMin() : ?float {
        return $this->min;
    }



    /**
     * Setter for maximum value
     *
     * @param float | null $value
     *
     * @return self
     */
    public function setMax(?float $value) : self {
        $this->max = $value;

        return $this;
    }

    /**
     * Getter for maximum value
     *
     * @return float | null
     */
    public function getMax() : ?float {
        return $this->max;
    }



    /**
     * Setter for maximum value length
     *
     * @param int | null $value
     *
     * @return self
     */
    public function setMaxLength(?int $value) : self {
        $this->maxLength = $value;

        return $this;
    }

    /**
     * Getter for maximum value length
     *
     * @return int | null
     */
    public function getMaxLength() : ?int {
        return $this->maxLength;
    }



    public function get() {
        if(is_null($this->compiled)){
            $this->execute();
        }

        return $this->compiled;
    }



    private function filterString($value) : string {

        $value = strval($value);

        if(!is_null($this->getRegExp())){
            $value = preg_replace("/{$this->getRegExp()}/isu", '', $value);
        }

        if(!is_null($this->getMaxLength()) && mb_strlen($value, 'UTF-8') > $this->getMaxLength()){
            $value = mb_substr($value, 0, $this->getMaxLength(), 'UTF-8');
        }

        return $this->getTrim() ? trim($value) : $value;
    }



    private function filterInt($value) : int {

        $value = intval($value);

        if(!is_null($this->getMin()) && $value < $this->getMin()){
            $value = $this->getMin();
        }

        if(!is_null($this->getMax()) && $value > $this->getMax()){
            $value = $this->getMax();
        }

        $tostr = strval($value);

        if(!is_null($this->getRegExp())){
            $tostr = preg_replace("/{$this->getRegExp()}/isu", '', $tostr);
        }

        if(!is_null($this->getMaxLength()) && mb_strlen($tostr, 'UTF-8') > $this->getMaxLength()){
            $tostr = mb_substr($tostr, 0, $this->getMaxLength(), 'UTF-8');
        }

        return intval($tostr);
    }



    private function filterFloat($value) : float {

        $value = floatval($value);

        if(!is_null($this->getMin()) && $value < $this->getMin()){
            $value = $this->getMin();
        }

        if(!is_null($this->getMax()) && $value > $this->getMax()){
            $value = $this->getMax();
        }

        $tostr = strval($value);

        if(!is_null($this->getRegExp())){
            $tostr = preg_replace("/{$this->getRegExp()}/isu", '', $tostr);
        }

        if(!is_null($this->getMaxLength()) && mb_strlen($tostr, 'UTF-8') > $this->getMaxLength()){
            $tostr = mb_substr($tostr, 0, $this->getMaxLength(), 'UTF-8');
        }

        return floatval($tostr);
    }



    private function filterBoolean($value) : float {

        return boolval($value);
    }



    private function filterArrayDeep(array $array, int $counter = 1) : array {

        if(!is_null($this->maxDeep) && $counter > $this->maxDeep){
            return $array;
        }

        $data = [];

        foreach($array as $k => $v){
            if(!is_array($v)){
                $data[$k] = $v;
            }else{
                if(!is_null($this->maxDeep) && $counter > $this->maxDeep){
                    continue;
                }

                $data[$k] = $this->filterArrayDeep($v, $counter+1);
            }
        }

        return $data;
    }

    private function filterArray($value) : array {

        if(!is_array($value)){
            return [];
        }

        $data = $this->filterArrayDeep($value, 1);

        return $data;
    }



    public function execute() : self {

        switch($this->getType()){
            case Filters::STRING: $this->compiled = $this->filterString($this->getValue()); break;

            case Filters::INTEGER: $this->compiled = $this->filterInt($this->getValue()); break;

            case Filters::FLOAT: $this->compiled = $this->filterFloat($this->getValue()); break;

            case Filters::BOOLEAN: $this->compiled = $this->filterBoolean($this->getValue()); break;

            case Filters::ARRAY: $this->compiled = $this->filterArray($this->getValue()); break;
        }



        return $this;
    }
}