<?php

namespace Core\Validator;

use Core\Database\Builder;
use Core\File\UploadedFile;

class Validator
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var array
     */
    protected $allowedRules = ['required', 'email', 'unique', 'in', 'mimes', 'max'];

    /**
     * @var array
     */
    protected $clientRules;

    /**
     * Create instance of Validator.
     * 
     * @param array $data
     * @param array $rules
     */
    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->clientRules = $rules;
    }

    /**
     * Check if the validation was failed.
     * 
     * @return boolean
     */
    public function failed()
    {
        return count($this->errors) > 0;
    }

    /**
     * Getter for validation errors.
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Launch validator.
     * 
     * @param  array $data
     * @param  array $rules
     * @return Validator
     */
    public static function validate(array $data, array $rules)
    {
        $validator = new static($data, $rules);

        $validator->parseRules();

        return $validator;
    }

    /**
     * Iterate all rules and parse it.
     * 
     * @return void
     */
    protected function parseRules()
    {
        foreach ($this->clientRules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $this->validateAttribute($attribute, $rule);
            }
        }
    }

    /**
     * Check if attribute value comply with the rule.
     * 
     * @param  string $attribute
     * @param  mixed  $rule
     * @param  mixed  $parameters
     * @return [      
     */
    protected function validateAttribute($attribute, $rule, $parameters = null)
    {
        if (is_array($rule)) {
            $parameters = $rule[$key = key($rule)];
            $rule = $key;
        }

        if (! in_array($rule, $this->allowedRules)) {
            return;
        }

        if (! method_exists($this, $method = "validate". ucwords($rule))) {
            return;
        }

        if ($this->$method($attribute, $this->getAttributeValue($attribute), $parameters) == false) {
            $this->setErrorMessage($attribute, $rule, $parameters);
        }
    }

    /**
     * Retrieve the value of the field.
     * 
     * @param  string $attribute
     * @return mixed
     */
    protected function getAttributeValue($attribute)
    {
        return array_key_exists($attribute, $this->data) ? $this->data[$attribute] : null;
    }

    /**
     * Add error messages to the validator's error list.
     * 
     * @param string $attribute
     * @param  mixed  $parameters
     * @param string $rule
     */
    protected function setErrorMessage($attribute, $rule, $parameters)
    {
        $this->errors[$attribute][] = $this->errorMessages(
            ucwords($attribute), $parameters
        )[$rule];
    }

    /**
     * List of error messages.
     * 
     * @param  string $attribute
     * @param  mixed  $parameters
     * @return array
     */
    protected function ErrorMessages($attribute = 'Undefined field', $parameters)
    {
        return [
            'required' => "$attribute is required",
            'email' => "$attribute should be a valid email address",
            'unique' => "$attribute should be unique",
            'in' => "$attribute should be only " . "'" . implode("', '", $parameters) . "'",
            'mimes' => "$attribute should be only type of $parameters",
            'max' => "$attribute should be less then $parameters Kb"
        ];
    }

    /**
     * Validate that a required attribute exists.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return boolean
     */
    protected function validateRequired($attribute, $value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif ($value instanceof File) {
            return (string) $value->getPath() != '';
        } elseif ($value instanceof UploadedFile) {
            return (string) $value->getPath() != '';
        }

        return true;
    }

    /**
     * Validate that an attribute is a valid e-mail address.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return boolean
     */
    protected function validateEmail($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate that an attribute is a unique.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  string $parameters
     * @return boolean
     */
    protected function validateUnique($attribute, $value, $parameters)
    {
        $builder = new Builder;
        
        $count = $builder->table($parameters)
            ->where($attribute, '=', $value)
            ->count();

        return $count < 1;
    }

    /**
     * Field under validation must be included in the given list of values.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array  $parameters
     * @return boolean
     */
    protected function validateIn($attribute, $value, $parameters)
    {
        return in_array($value, $parameters);
    }

    /**
     * Image must be type of the given values.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array  $parameters
     * @return boolean
     */
    protected function validateMimes($attribute, $value, $parameters)
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            return false;
        }

        $mimeUnderValidation = getimagesize($value->getPath())['mime'];

        foreach (explode(',', $parameters) as $mimeRule) {
            if (strpos($mimeUnderValidation, $mimeRule)) {
                return true;
                break;
            }
        }

        return false;
    }

    /**
     * Image must be less than the given size.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array  $parameters
     * @return boolean
     */
    protected function validateMax($attribute, $value, $parameters)
    {
        if ($value instanceof UploadedFile && $value->isValid()) {
            return $value->getSize() <= $parameters * 1024;
        }

        return false;
    }  

}