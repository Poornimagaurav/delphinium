<?php namespace Delphinium\Dev\Components;

use Delphinium\Roots\UpdatableObjects\Module;
use Delphinium\Roots\UpdatableObjects\ModuleItem;
use Delphinium\Roots\Models\Assignment;
use Delphinium\Roots\Models\ModuleItem as DbModuleItem;
use Delphinium\Roots\Models\Quizquestion;
use Delphinium\Roots\Roots;
use Delphinium\Roots\Utils;
use Delphinium\Roots\Requestobjects\SubmissionsRequest;
use Delphinium\Roots\Requestobjects\ModulesRequest;
use Delphinium\Roots\Requestobjects\AssignmentsRequest;
use Delphinium\Roots\Requestobjects\QuizRequest;
use Delphinium\Roots\Requestobjects\AssignmentGroupsRequest;
use Delphinium\Roots\Enums\ActionType;
use Delphinium\Roots\Enums\ModuleItemType;
use Delphinium\Roots\Enums\CompletionRequirementType;
use Delphinium\Roots\DB\DbHelper;
use Delphinium\Roots\Lmsclasses\CanvasHelper;
use Cms\Classes\ComponentBase;
use \DateTime;
use \DateTimeZone;
use GuzzleHttp\Client;
use GuzzleHttp\Post\PostFile;
use Delphinium\Iris\Components\Iris;
use Cms\Classes\ComponentManager;
use \Delphinium\Blade\Classes\Rules\RuleBuilder;
use \Delphinium\Blade\Classes\Rules\RuleGroup;
use Delphinium\Roots\Guzzle\GuzzleHelper;
use Delphinium\Blossom\Components\Grade;
use Delphinium\Blossom\Components\Experience;

class TestRoots extends ComponentBase
{
    public $roots;
    public $canvasHelper;
    public $dbHelper;
    public function componentDetails()
    {
        return [
            'name'        => 'Test Roots',
            'description' => 'This component will test the Roots API'
        ];
    }
    
    public function onRun()
    {  
        $this->roots = new Roots();
        $this->canvasHelper = new CanvasHelper();
        $this->dbHelper = new DbHelper();
//        $this->refreshCache();
//        $this->test();
//        $this->testBasicModulesRequest();
//        $this->testDeleteTag();
//        $this->testAddingUpdatingTags();
//        $this->testUpdatingModuleItem();
//        $this->testUpdatingModule();
        
//        $this->testDeletingModuleItem();
//        $this->testDeletingModule();   //need to double check this one
        
//        $this->testAddingModule();
//        $this->testAddingModuleItem();
//        
//        $this->testingGettingAssignments();
//        $this->testGettingSingleAssignment();
        
//        $this->testAssignmentGroups();
//        $this->testSingleAssignmentGroup();
//        
//        $this->testGettingSingleSubmissionSingleUserSingleAssignment();
//        $this->testGettingAllSubmissionForSingleAssignment();
//        $this->testGettingMultipleSubmissionsForSingleStudent();
//        $this->testGettingMultipleSubmissionsAllStudents();
//        $this->testGettingAllSubmissionsAllStudents();
//        $this->testGettingMultipleSubmissionsMultipleStudents();
//        $this->testGettingSubmissions();
//        $this->testFileUpload();
//        $this->testAddingAssignment();
//        $this->testStudentAnalyticsAssignmentData();
//        $this->testGetCourse();
//        $this->testGetAccount();
//        $this->testGetEnrollments();
//        $this->testGetQuiz();
//        $this->testGetQuizQuestions();
//        $this->testGetAllQuizzes();
//        $this->testGetPages();
        $this->testQuizTakingWorkflow();
//        $this->testIsQuestionAnswered();
//        $this->testSubmitQuiz();
    }
    
    private function testBasicModulesRequest()
    { 
        $moduleId = null;//380200;
        $moduleItemId = null;//2368085;
        $includeContentDetails = true;
        $includeContentItems = true;
        $module = null;
        $moduleItem = null;
        $freshData = true;
                
        $req = new ModulesRequest(ActionType::GET, $moduleId, $moduleItemId, $includeContentItems, 
                $includeContentDetails, $module, $moduleItem , $freshData) ;
        
        $res = $this->roots->modules($req);
        echo json_encode($res);
    }
    
    
    private function testUpdatingModule()
    {   
        //380212
        $empty =  array();
        $module = new Module(null, null, null, null, 22);
        $req = new ModulesRequest(ActionType::PUT, 380206, null,  
            false, false, $module, null , false);
        
        $res = $this->roots->modules($req);
        
//        $name = "Updated from backend";
//        
//        $format = DateTime::ISO8601;
//        $date = new DateTime("now");
//        $date->add(new DateInterval('P1D'));
//        $unlock_at = $date;
//        $prerequisite_module_ids =array("380199","380201");
//        $published = true;
//        $position = 4;
//        
//        $module = new Module($name, $unlock_at, $prerequisite_module_ids, $published, $position);
//        
//        
//        $moduleId = 457494;
//        $moduleItemId = null;
//        $includeContentItems = false;
//        $includeContentDetails = false;
//        $moduleItem = null;
//        $freshData = false;
//        
//        //update a module (changing title and published to false)
//        $req = new ModulesRequest(ActionType::PUT, $moduleId, $moduleItemId,  
//            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
//        
//        $res = $this->roots->modules($req);
    }
    
    private function testUpdatingModuleItem()
    {
        //added
        $tags = null;//array('New Tag', 'Another New Tag');
        $title = "New Title from back end";
        $modItemType = null;// Module type CANNOT be updated
        $content_id = 2078183;
        $completion_requirement_min_score = null;//7;
        $completion_requirement_type = null;//CompletionRequirementType::MUST_SUBMIT;
        $page_url = null;//"http://www.gmail.com";
        $published = true;
        $position = 1;//2;
        
        $moduleItem = new ModuleItem($title, $modItemType, $content_id, $page_url, null, $completion_requirement_type, 
                $completion_requirement_min_score, $published, $position, $tags);
        //end added
        
        $moduleId = 457097;
        $moduleItemId = 2885671;
        $includeContentItems = false;
        $includeContentDetails = false;
        $module = null;
        $freshData = false;
        
        $req = new ModulesRequest(ActionType::PUT, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
        
        $res = $this->roots->modules($req);
    }
    
    
    private function testDeletingModuleItem()
    {
        $moduleId = 457097;
        $moduleItemId = 2887052;
        $includeContentItems = false;
        $includeContentDetails = false;
        $module = null;
        $moduleItem = null;
        $freshData = false;
        
        $req = new ModulesRequest(ActionType::DELETE, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
        
        $res = $this->roots->modules($req);
        echo json_encode($res);
    }
    
    private function testDeletingModule()
    {
        $moduleId = 526591;
        $moduleItemId = null;
        $includeContentItems = false;
        $includeContentDetails = false;
        $module = null;
        $moduleItem = null;
        $freshData = false;
        
        $req = new ModulesRequest(ActionType::DELETE, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
        
//        \Cache::flush();
        $res = $this->roots->modules($req);
        echo json_encode($res);
    }
    private function testAddingModule()
    {
        $name = "Module from backend";
        
        $format = DateTime::ISO8601;
        $date = new DateTime("now");
//        $date->add(new DateInterval('P1D'));
        $unlock_at = $date;
        $prerequisite_module_ids =array("380199","380201");
        $published = true;
        $position = 1;
        
        $module = new Module($name, $unlock_at, $prerequisite_module_ids, $published, $position);
        $moduleId = null;
        $moduleItemId = null;
        $includeContentItems = false;
        $includeContentDetails = false;
        $moduleItem = null;
        $freshData = false;
        
        $req = new ModulesRequest(ActionType::POST, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
        
        $res = $this->roots->modules($req);
        echo json_encode($res);
    }
    
    private function testAddingModuleItem()
    {
        $tags = array('Brand', 'New');
        $title = "Module Item created from the backend";
        $modItemType = ModuleItemType::FILE;
        $content_id = 49051689;
        $completion_requirement_min_score = 6;
        $page_url = "http://www.google.com";
        $published = true;
        $position = 1;
        
        $moduleItem = new ModuleItem($title, $modItemType, $content_id, $page_url, null, CompletionRequirementType::MUST_SUBMIT, 
                $completion_requirement_min_score, $published, $position, $tags);
                
        $moduleId = 457494;
        $moduleItemId = null;
        $includeContentItems = false;
        $includeContentDetails = false;
        $freshData = false;
        $module = null;
        
        $req = new ModulesRequest(ActionType::POST, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails,  $module, $moduleItem , $freshData);
        
        $res = $this->roots->modules($req);
        echo json_encode($res);
    }
    
    private function testingGettingAssignments()
    {
        $req = new AssignmentsRequest(ActionType::GET, null, false, null, true);
//        $req = new AssignmentsRequest(ActionType::GET);
        
        $res = $this->roots->assignments($req);
        echo json_encode($res);
    }
    
    private function testGettingSingleAssignment()
    {
        $assignment_id = 1660430;
        $freshData = false;
        $includeTags = true;
        $req = new AssignmentsRequest(ActionType::GET, $assignment_id, $freshData, null, $includeTags);
        $res = $this->roots->assignments($req);
        echo json_encode($res);
    }
    
    private function testAssignmentGroups()
    {
        $include_assignments = true;
        $fresh_data = true;
        $assignmentGpId = null;
        $req = new AssignmentGroupsRequest(ActionType::GET, $include_assignments, $assignmentGpId, $fresh_data);
        
        $res = $this->roots->assignmentGroups($req);
        echo json_encode($res);   
    }
    
    private function testSingleAssignmentGroup()
    {
        $assignment_group_id = 378245;
        $req = new AssignmentGroupsRequest(ActionType::GET, true, $assignment_group_id);
        
        $res = $this->roots->assignmentGroups($req);
        echo json_encode($res);
    }
    
    
    private function testGettingSingleSubmissionSingleUserSingleAssignment()
    {
        $studentIds = array(1489289);
        $assignmentIds = array(1660419);
        $multipleStudents = false;
        $multipleAssignments = false;
        $allStudents = false;
        $allAssignments = false;
        
        //can have the student Id param null if multipleUsers is set to false (we'll only get the current user's submissions)
        $req = new SubmissionsRequest(ActionType::GET, $studentIds, $allStudents, 
                $assignmentIds, $allAssignments, $multipleStudents, $multipleAssignments);
        
        $res = $this->roots->submissions($req);
        echo json_encode($res);
    }
    
    private function testGettingAllSubmissionForSingleAssignment()
    {
        $studentIds = array(10733259,10733259);
        $assignmentIds = array(1660406);//array(1660419);
        $multipleStudents = true;
        $multipleAssignments = false;
        $allStudents = true;
        $allAssignments = false;
        
        //can have the student Id param null if multipleUsers is set to false (we'll only get the current user's submissions)
        $req = new SubmissionsRequest(ActionType::GET, $studentIds, $allStudents, 
                $assignmentIds, $allAssignments, $multipleStudents, $multipleAssignments);
        
        $res = $this->roots->submissions($req);
        echo json_encode($res);
    }
    
    private function testGettingMultipleSubmissionsForSingleStudent()
    {
        if(!isset($_SESSION)) 
        { 
            session_start(); 
    	}
        $studentId = $_SESSION['userID'];
        
        $studentIds = array($studentId);
        $assignmentIds = array();
        $multipleStudents = false;
        $multipleAssignments = true;
        $allStudents = false;
        $allAssignments = true;
        
        //can have the student Id param null if multipleUsers is set to false (we'll only get the current user's submissions)
        
        $req = new SubmissionsRequest(ActionType::GET, $studentIds, $allStudents, 
                $assignmentIds, $allAssignments, $multipleStudents, $multipleAssignments);
        
        $res = $this->roots->submissions($req);
        echo json_encode($res);
    }
    
    private function testGettingMultipleSubmissionsAllStudents()
    {
        $studentIds = null;
        $assignmentIds = array(1660419, 1660406, 1660412);
        $multipleStudents = true;
        $multipleAssignments = true;
        $allStudents = true;
        $allAssignments = false;
        
        //can have the student Id param null if multipleUsers is set to false (we'll only get the current user's submissions)
        
        $req = new SubmissionsRequest(ActionType::GET, $studentIds, $allStudents, 
                $assignmentIds, $allAssignments, $multipleStudents, $multipleAssignments);
        
        $res = $this->roots->submissions($req);
        echo json_encode($res);
    }
       
    private function testGettingAllSubmissionsAllStudents()
    {
        $studentIds = null;
        $assignmentIds = array();
        $multipleStudents = true;
        $multipleAssignments = true;
        $allStudents = true;
        $allAssignments = true;
        $includeTags = true;
        
        //can have the student Id param null if multipleUsers is set to false (we'll only get the current user's submissions)
        
        $req = new SubmissionsRequest(ActionType::GET, $studentIds, $allStudents, 
                $assignmentIds, $allAssignments, $multipleStudents, $multipleAssignments, $includeTags);
        
        $res = $this->roots->submissions($req);
        echo json_encode($res);
    }
    private function testGettingMultipleSubmissionsMultipleStudents()
    {//This throws an error because I'm not authorized to retrieve submissions in behalf of other students
        $studentIds = array(10733259,10733259);
        $assignmentIds = array(1660419, 1660406, 1660412);
        $multipleStudents = true;
        $multipleAssignments = true;
        $allStudents = false;
        $allAssignments = false;
        
        //can have the student Id param null if multipleUsers is set to false (we'll only get the current user's submissions)
        
        $req = new SubmissionsRequest(ActionType::GET, $studentIds, $allStudents, 
                $assignmentIds, $allAssignments, $multipleStudents, $multipleAssignments);
        
        $res = $this->roots->submissions($req);
        echo json_encode($res);
    }
    
    private function refreshCache()
    {
        $moduleId = null;
        $includeContentDetails = true;
        $includeContentItems = true;
        $moduleItemId = null;
        $refreshData = true;
        
        $req = new ModulesRequest(ActionType::GET, $moduleId, $moduleItemId, $includeContentItems, $includeContentDetails, null, 
                null, $refreshData);
        
        $res = $this->roots->modules($req);
        echo json_encode($res);
    }
    
    public function convertDatesUTCLocal()
    {
        $utcTime = Utils::convertLocalDateTimeToUTC(new DateTime('now'));
        echo "UTC:".json_encode($utcTime);
        
        $localTime = Utils::convertUTCDateTimetoLocal($utcTime);
        echo "MOUNTAIN".json_encode($localTime);
        
    }
    
    
   

    function testAddingUpdatingTags()
    {
        //To add/update tags the bare minimum that is needed is the content id and the tags.
        //A moduleItem can be updated on Canvas and have tags added to it in the same request IF the module_item_id is provided
        
        $tags = array('New Tag', 'Another New Tag');
        $title = null;
        $modItemType = null;
        $content_id = 49051678;
        $completion_requirement_min_score = null;
        $completion_requirement_type = null;
        $page_url = null;
        $published = true;
        $position = null;
        
        $moduleItem = new ModuleItem($title, $modItemType, $content_id, $page_url, null, $completion_requirement_type, 
                $completion_requirement_min_score, $published, $position, $tags);
        //end added
        
        $moduleId = null;
        $moduleItemId = null;
        $includeContentItems = false;
        $includeContentDetails = false;
        $module = null;
        $freshData = false;
        
        $req = new ModulesRequest(ActionType::PUT, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
        
        $res = $this->roots->modules($req);
        return $res;
    }
    
    public function testDeleteTag()
    {
        $tags = array('New Tag', 'Another New Tag');
        $title = null;
        $modItemType = null;
        $content_id = 49051678;
        $completion_requirement_min_score = null;
        $completion_requirement_type = null;
        $page_url = null;
        $published = true;
        $position = null;
        
        $moduleItem = new ModuleItem($title, $modItemType, $content_id, $page_url, null, $completion_requirement_type, 
                $completion_requirement_min_score, $published, $position, $tags);
        //end added
        
        $moduleId = null;
        $moduleItemId = null;
        $includeContentItems = false;
        $includeContentDetails = false;
        $module = null;
        $freshData = false;
        
        $req = new ModulesRequest(ActionType::PUT, $moduleId, $moduleItemId,  
            $includeContentItems, $includeContentDetails, $module, $moduleItem , $freshData);
        
        $res = $this->roots->modules($req);
        return $res;
    }
    
    public function testFileUpload()
    {
//        /api/v1/courses/:course_id/files
        
    }
    
    public function testAddingAssignment()
    {
        $date = new DateTime("now");
        $assignment = new Assignment();
        $assignment->name = "my new name";
        $assignment->description = "This assignment was created from backend";
        $assignment->points_possible = 30;
        $assignment->due_at = $date;
        
        $req = new AssignmentsRequest(ActionType::POST, null, null, $assignment);
        
        $res = $this->roots->assignments($req);
        echo json_encode($res);
    }
    
    public function testStudentAnalyticsAssignmentData()
    {
        $res = $this->roots->getAnalyticsStudentAssignmentData(false);
        echo json_encode($res);
    }
    
    public function testGetCourse()
    {
        $res = $this->roots->getCourse();
        echo json_encode($res);
    }
    
    public function testGetAccount()
    {
        $accountId = 16;
        $res = $this->roots->getAccount($accountId);
        echo json_encode($res);
    }

    public function testGetEnrollments()
    {
        $res = $this->roots->getUserEnrollments();
        echo json_encode($res);
    }
    
    public function testGetAllQuizzes()
    {
//        $req = new QuizRequest(ActionType::GET, null, $fresh_data = false, true);
        $req = new QuizRequest(ActionType::GET, null, $fresh_data = true, true);
        echo json_encode($this->roots->quizzes($req));
    }
    public function testGetQuiz()
    {   
        $req = new QuizRequest(ActionType::GET, 464878, $fresh_data = true, true);
        $result = $this->roots->quizzes($req);
        echo json_encode($result);
    }
    public function testGetPages()
    {
        echo json_encode($this->roots->getPages());
    }
    
    public function testGetQuizQuestions()
    {
        $req = new QuizRequest(ActionType::GET, 621540, false, true);
        $result = $this->roots->quizzes($req);
        
        echo json_encode($result);
//        foreach($result['questions'] as $question)
//        {
//            
//            $answers = $question['answers'];
//            $obj = json_decode($answers, true);
//            foreach($obj as $answer)
//            {
//                echo json_encode($answer['text']);
//            }
//        }
        
    }
    public function testQuizTakingWorkflow()
    {
        $quizId = 655691;
        $questionId = 11464509;
        
        $quizSubmission = $this->roots->getQuizSubmission($quizId);
        if(is_null($quizSubmission))
        {//it wasn't on canvas or in the db -- create a new submission
            
            echo "was null. Started new quiz taking session";
            $quizSubmission = $this->roots->postQuizTakingSession($quizId);
        }
        
//        echo json_encode($quizSubmission);
        //get the question and see if it's answered
        $isAnswered = $this->roots->isQuestionAnswered($quizId, $questionId, $quizSubmission->quiz_submission_id);
        
        if($isAnswered){
            echo "was answered";//do something if the question has been answered
        }
        else
        {//answer it. Still working on this
//            echo "was not answered";
//            $quizQuestion = $this->roots->getQuizQuestion($quizId, $questionId);

            $questionsWrap = new \stdClass();
            $questionsWrap->attempt = $quizSubmission->attempt;
            $questionsWrap->validation_token =  $quizSubmission->validation_token;

            $quizQuestionsArr = array();

            $answersArr = array();
            $answer = new \stdClass();
            $answer->id = $questionId;
            $answer->answer = 'True';
            $answersArr[] = $answer;

            $questionsWrap->quiz_questions = $answersArr;
//
//            echo json_encode($questionsWrap);
//  
//              //the "answer" will vary between question types
//            switch(strtolower($quizQuestion->type))
//            {
//                case "text":
//                    break;
//                case "multiple_choice_question":
//                    $answer->answer = 1;
//                    break;
//
//            }
//
//            $questionsWrap[] = $answer;
//            //answer question
//



            $result =$this->canvasHelper->postAnswerQuestion($quizSubmission, $questionsWrap);
//            echo json_encode($result);
        }
        
        //submit the quiz
//        $res = $this->roots->postTurnInQuiz($quizId, $quizSubmission);
//        echo json_encode($res);
    }
    
    
    public function testIsQuestionAnswered()
    {
        $quizSubmissionId = 8287196;
        $quizId = 621794;
        $questionId = 10902238;
        $answer = $this->canvasHelper->isQuestionAnswered($quizId, $questionId, $quizSubmissionId);
        if($answer)
        {
            echo json_encode($answer);
        }
        else
        {
            echo "no";
        }
    }
    
    public function testSubmitQuiz()
    {
        if(!isset($_SESSION)) 
        { 
            session_start(); 
    	}
        $userId = $_SESSION['userID'];
        $quizId = 621753;
        $dbHelper = new DbHelper();
        $canvasHelper = new CanvasHelper();
        
//        $canvasHelper->postQuizTakingSession($quizId);
        
        $quizSubmission = $dbHelper->getQuizSubmission($quizId, $userId);
        $result = $canvasHelper->postSubmitQuiz($quizSubmission);
        echo json_encode($result);
    }
    
    private function convertToUTC()
    {
        $date = new DateTime("now", new \DateTimeZone('America/Denver'));
        echo json_encode($date);
        
        $UTC = new DateTimeZone("UTC");
        $utc_date = $date->setTimezone( $UTC );
        echo json_encode($utc_date);
    }
    
    
    public function test()
    {
        $req = new SubmissionsRequest(ActionType::GET, array(), true, array(), true, true, true, false, true);
        $result = $this->roots->submissions($req);

        
//        echo json_encode($result);
        
//https://uvu.instructure.com/api/v1/courses/381983/students/submissions?student_ids%5B%5D=483474&student_ids%5B%5D=944587&student_ids%5B%5D=1576866&student_ids%5B%5D=553940&student_ids%5B%5D=1241607&student_ids%5B%5D=1463096&student_ids%5B%5D=890679&student_ids%5B%5D=1529330&student_ids%5B%5D=488472&student_ids%5B%5D=771735&student_ids%5B%5D=547197&student_ids%5B%5D=539445&student_ids%5B%5D=741224&student_ids%5B%5D=554968&student_ids%5B%5D=1485016&student_ids%5B%5D=471788&student_ids%5B%5D=798500&student_ids%5B%5D=512347&student_ids%5B%5D=557699&student_ids%5B%5D=462755&student_ids%5B%5D=485519&student_ids%5B%5D=480907&student_ids%5B%5D=469426&student_ids%5B%5D=491649&student_ids%5B%5D=944587&student_ids%5B%5D=1576866&student_ids%5B%5D=553940&student_ids%5B%5D=1241607&student_ids%5B%5D=1463096&student_ids%5B%5D=890679&student_ids%5B%5D=1529330&student_ids%5B%5D=488472&student_ids%5B%5D=771735&student_ids%5B%5D=547197&student_ids%5B%5D=539445&student_ids%5B%5D=741224&student_ids%5B%5D=554968&student_ids%5B%5D=1485016&student_ids%5B%5D=471788&student_ids%5B%5D=798500&student_ids%5B%5D=512347&student_ids%5B%5D=557699&student_ids%5B%5D=462755&student_ids%5B%5D=485519&student_ids%5B%5D=480907&student_ids%5B%5D=469426&student_ids%5B%5D=491649&grouped=true&access_token=14~DQbVNTYt3E8djaiyUGckBdbPwAoGqHgIK5UYyIJBciFRikr38wSDXScgeqWGCShL&per_page=5000

//        $quizId = 623422;
//        $questionId = 10897397;
//        $canvasHelper = new CanvasHelper();
//        $dbHelper = new DbHelper();
//        $res = $canvasHelper->postQuizTakingSession($quizId);
//        
//        echo json_encode($res);
            
        
        
        
        
//        $canvasHelper->getQuizSubmissionsFromCanvas($quizId);
        
//        $req = new ModulesRequest(ActionType::GET, 380206, null, true, true, null, null , false);
//        $db = new \Delphinium\Roots\DB\DbHelper();
//        $res = $db->getModuleData($req);
//        
//        echo json_encode($res);
        
        
        
        
        
        
        
//        $this->convertDatesUTCLocal();
//        $now = new DateTime(date("Y-m-d"));
//        echo json_encode($now);
//        
//        
//        
//        $rb = new RuleBuilder;
//
//        $bonus_90 = $rb->create('current_user_submissions', 'submission',
//        $rb['submission']['score']->greaterThan($rb['score_threshold']),
//        [
//            $rb['(bonus)']->assign($rb['(bonus)']->add($rb['points']))
//        ]);
//        
//        $rb['(bonus)'] = 0;
//        $rb['submission']['score'] = 0;
//        $rb['score_threshold'] = 0;
//        $rb['point'] = 0;
//
//        $rg = new RuleGroup('submissionstest');
//        $rg->add($bonus_90);
//        $rg->saveRules();
        
//        $manager = ComponentManager::instance();
//       echo json_encode($manager->listComponents());
        
        

    }
    
}

