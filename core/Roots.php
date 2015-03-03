<?php namespace Delphinium\Core;

use Delphinium\Core\RequestObjects\SubmissionsRequest;
use Delphinium\Core\RequestObjects\ModulesRequest;
use Delphinium\Core\RequestObjects\AssignmentsRequest;
use Delphinium\Core\Enums\CommonEnums\Lms;
use Delphinium\Core\Enums\CommonEnums\DataType;
use Delphinium\Core\Enums\CommonEnums\ActionType;
use Delphinium\Core\lmsClasses\Canvas;
use Delphinium\Core\Cache\CacheHelper;

class Roots
{
    /*
     * Public Functions
     */
    
    public function modules(ModulesRequest $request)
    {
        switch($request->actionType)
        {
            case (ActionType::GET):
                $cacheHelper = new CacheHelper();
                $data = $cacheHelper->searchModuleDataInCache($request);
                if($data)
                {//if data is null it means it wasn't in cache... need to get it from 
                    return $data;
                }
                else
                {
                    switch ($request->lms)
                    {
                        case (Lms::CANVAS):
                            $canvas = new Canvas(DataType::MODULES);
                            $canvas->getModuleData($request);
                            return $cacheHelper->searchModuleDataInCache($request);
                        default:
                            $canvas = new Canvas(DataType::MODULES);
                            $canvas->getModuleData($request);
                            return $cacheHelper->searchModuleDataInCache($request);

                    }
                }
                
                
            case(ActionType::PUT):
                switch ($request->lms)
                    {
                        case (Lms::CANVAS):
                            $canvas = new Canvas(DataType::MODULES);
                            return $canvas->putData($request);
                        default:
                            $canvas = new Canvas(DataType::MODULES);
                            return $canvas->putData($request);
                    }
                //update cache
                $cacheHelper = new CacheHelper();
                $cacheHelper->updateCache($request);
                break;
            case(ActionType::POST):
                break;
            case(ActionType::DELETE):
                break;
        }
        
    }
    
    public function submissions(SubmissionsRequest $request)
    {
        $result;
        switch ($request->lms)
        {
            case (Lms::CANVAS):
                $canvas = new Canvas(DataType::SUBMISSIONS);
                $result = $canvas->processSubmissionsRequest($request);
                break;
            default:
                $canvas = new Canvas(DataType::SUBMISSIONS);
                $result = $canvas->processSubmissionsRequest($request);
                break;
                
        }
            
        return $result;
    }
    
    public function assignments(AssignmentsRequest $request)
    {
        return true;
    }
    
}
