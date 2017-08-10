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
    protected $allowedRules = [
        'required', 'maybeRequired', 'email', 'unique', 'in', 'mimes', 'max', 'exists'
    ];

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
                [$rule, $parameters] = $this->parseRule($rule);

                if ($this->shouldStopValidateAtrribute($attribute, $rule, $parameters)) {         
                    continue 2;
                }

                $this->validateAttribute($attribute, $rule, $parameters);
            }
        }
    }

    /**
     * Check if attribute has no need further validation.
     * 
     * @param  string $attribute
     * @param  mixed  $rule
     * @param  mixed  $parameters
     * @return boolean
     */
    protected function shouldStopValidateAtrribute($attribute, $rule, $parameters)
    {
        $value = $this->getAttributeValue($attribute);

        if ($rule === 'maybeRequired' && $value === null) {
                return true;
        }

        if ($rule === 'maybeRequired' && $value instanceof UploadedFile 
            && empty($value->getPath())) {
                return true;
        }

        return false;
    }

    /**
     * Parse rule if it is array.
     * 
     * @param  mixes $rule
     * @param  mixed $parameters
     * @return array
     */
    protected function parseRule($rule, $parameters = null)
    {
        if (is_array($rule)) {
            $parameters = $rule[$key = key($rule)];
            $rule = $key;
        }

        return [$rule, $parameters];
    }

    /**
     * Check if attribute value comply with the rule.
     * 
     * @param  string $attribute
     * @param  mixed  $rule
     * @param  mixed  $parameters
     * @return void    
     */
    protected function validateAttribute($attribute, $rule, $parameters)
    {
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
            $attribute, $parameters
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
            'email' => "$attribute should be a valid email address",
            'exists' => "$attribute should exists in table $parameters",
            'in' => "$attribute should be only $parameters",
            'max' => "$attribute should be less then $parameters Kb",            
            'maybeRequired' => "",
            'mimes' => "$attribute should be only type of $parameters",
            'required' => "$attribute is required",
            'unique' => "$attribute should be unique",
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
     * Validation need only of value of attribute is not null.
     * Always accept true as this rule used only for defining is the next rules should be checked.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return boolean
     */
    protected function validateMaybeRequired($attribute, $value)
    {
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
        return in_array($value, explode(',', $parameters));
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

    /**
     * Validate that an attribute exists in the table.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  string $parameters
     * @return boolean
     */
    protected function validateExists($attribute, $value, $parameters)
    {
        $builder = new Builder;
        
        [$table, $column] = explode(':', $parameters);

        $count = $builder->table($table)
            ->where($column, '=', $value)
            ->count();

        return $count >= 1;
    }
}