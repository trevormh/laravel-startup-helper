<?php

namespace trevormh\LaravelStartupHelper;

trait ValidationHelper
{
    private $validator;

    /**
     * @param object $validator
     * @return void
     */
    public function addValidator($validator) : void
    {
        $this->validator = $validator;
    }

    public function addErrorMessage($attribute, $message) : void
    {
        if (empty($this->validator)) {
            throw new \Exception('No validator class has been added');
        }
        $this->validator->customMessages[$attribute] = $message;
    }
}