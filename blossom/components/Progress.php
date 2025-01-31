<?php namespace Delphinium\Blossom\Components;

use Cms\Classes\ComponentBase;
use Delphinium\Roots\Roots;

class Progress extends ComponentBase
{
	public $roots;
    public function componentDetails()
    {
        return [
            'name'        => 'Progress',
            'description' => 'Shows students progress toward finishing the course'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun()
    {
        $this->addJs("/plugins/delphinium/blossom/assets/javascript/progress.js");
        $this->addJs("/plugins/delphinium/blossom/assets/javascript/d3.min.js");
        $this->addCss("/plugins/delphinium/blossom/assets/css/main.css");
        $this->addCss("/plugins/delphinium/blossom/assets/css/progress.css");

        $this->roots = new Roots();
        try {
            $res = $this->roots->getAnalyticsStudentAssignmentData();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo "In order for the 'Progress' app to run properly you must be a student or you must go in 'Student View'";
            return;
        }
        //var_dump($res);
        $possable = 0;
        $completed = 0;
        foreach ($res as $assignment) {
            foreach ($assignment as $key => $submission) {
                if($key=="submission"){
                    $completed++; 
                }
            }
            $possable++; 
        }
        $progress = $completed / $possable;
        $this->page['progress'] = $progress;

    }

}