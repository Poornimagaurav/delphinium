<?php namespace Delphinium\Core\RequestObjects;

use Delphinium\Core\Enums\CommonEnums\ActionType;
use Delphinium\Core\Enums\CommonEnums\Lms;
use Delphinium\Core\Exceptions\InvalidParameterInRequestObjectException;

class AssignmentsRequest extends RootsRequest
{
    private $assignment_id;
    
    function getAssignment_id() {
        return $this->assignment_id;
    }
    
    function __construct($actionType, $assignment_id = null) 
    {
        //this takes care of setting the lms and the ActionType in the parent class (RootsRequest)
        parent::__construct($actionType);

        $lms = strtoupper($_SESSION['lms']);
        if(Lms::isValidValue($lms))
        {
            $this->lms = $lms;
        }
        else
        {
            throw new \Exception("Invalid LMS"); 
        }
        
        if($assignment_id && !is_integer($assignment_id))
        {
            throw new InvalidParameterInRequestObjectException(get_class($this),"assignment_id", "Parameter must be an integer");
        }
        
        $this->assignment_id = $assignment_id;
    }
}