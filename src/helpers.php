<?php

namespace Shalvah\Ensure;

function when($condition)
{
    return new Requirement(null, $condition);
}

function ensure($rule)
{
    return new Requirement($rule);
}
