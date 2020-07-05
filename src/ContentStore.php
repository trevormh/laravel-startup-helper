<?php

namespace trevormh\LaravelStartupHelper;

trait ContentStore
{
    private $content = [];

    /**
     * @param array $args
     * @return void
     */
    public function addContent(array $args)
    {
        foreach ($args as $key => $val) {
            $this->content[$key] = $val;
        }
    }

    /**
     * @param string|integer $field
     * @return string|array if field is provided a string will be returned, otherwise array of all content added to store will be returned
     */
    public function get($field = null) 
    {
        if ($field !== null) {
            if (!isset($this->content[$field])) {
                throw new \Exception('Field ' . $field . ' does not exist in LaravelStartupHelper content store');
            }
            return $this->content[$field];
        }
        return $this->content;
    }
}