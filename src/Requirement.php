<?php

namespace Shalvah\Ensure;

class Requirement
{
    /**
     * @var bool|callable| null
     * When this condition is a boolean true, or a callable which returns boolean true,
     * this rule wil be enforced. If this is null, the rule will not be enforced
     */
    protected $when = null;

    /**
     * @var array
     * The rules covered by this requirement. All rules must pass (be boolean true or callable which returns true),
     * or else the 'deny' response wil be triggered
     */
    protected $rules = [];

    public function __construct($rule = null, $when = null)
    {
        !is_null($when) && $this->when = $when;
        !is_null($rule) && $this->rules[] = $rule;
    }

    /**
     * Add a rule that must be satisfied for this requirement to pass
     * @param $rule
     * @return $this
     */
    public function ensure($rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * When any of the rules for this requirement fails, a RequirementFailedException will be thrown
     * This method allows you to specify the message and optional data to be passed to the exception
     *
     */
    public function orElseDeny(string $message, $data = null)
    {
        if (!$this->requirementApplies()) {
            return;
        }

        foreach ($this->rules as $rule) {
            if (is_callable($rule)) {
                $rule = $rule();
            }

            if ($rule === false) {
                throw new RequirementFailedException($message, $data);
            }
        }
    }

    protected function requirementApplies()
    {
        $condition = $this->when;
        if (is_null($condition)) {
            return true;
        }
        $result = is_callable($condition) ? $condition() : $condition;
        return $result === true;
    }
}


function when($condition)
{
    return new Requirement(null, $condition);
}

function ensure($rule)
{
    return new Requirement($rule);
}
