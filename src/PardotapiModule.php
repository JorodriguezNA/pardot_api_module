<?php namespace Pardot\PardotapiModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class PardotapiModule extends Module
{

    /**
     * The navigation display flag.
     *
     * @var bool
     */
    protected $navigation = true;

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-puzzle-piece';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'instances' => [
            'buttons' => [
                'new_instance',
            ],
        ],
    ];

    public function checkProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray) 
    {
        //Checking for a Prospect
        //$upsert = $rest_domain. '/api/prospect/version/4/do/upsert/'

        $prospectCheck = $rest_domain.'/api/prospect/version/4/do/query?user_key='.$pardot_user_key.'&api_key='. $pardot_api_key;
        
        $getProspect = simplexml_load_file($prospectCheck);
        $prospectSearch = $getProspect->result;
        //echo json_encode($prospectSearch);
        $foundProspect = 'nan';
        foreach($prospectSearch->prospect as $thisProspect)
        {
            if($thisProspect->email == $pardotArray['email'])
            {
                $foundProspect = $thisProspect;
                
                //echo json_encode($prospectSearch);
            }   
            //echo json_encode($thisProspect);
        }
        if ($foundProspect != 'nan')
        {
            $pardotArray['prospect_id'] = $foundProspect->id;

            $this->updateProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray);
        } else 
        {
            $this->createProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray);
        }
    }

    

    public function createProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray) 
    {
        $pardotArray['isnew'] = true;
        $pardotArrayEmail = $pardotArray['email'];
        $rest_function = 'prospect/version/4/do/create/email/'.$pardotArray['email'];

//Create the post arguments
        $pardot_string = "";
        foreach ($pardotArray as $key=>$value) { 
            $pardot_string .= $key.'='.$value.'&';
        }

        $postArgs = $pardot_string.'api_key='.$pardot_api_key.'&user_key='.$pardot_user_key;
        
        $createProspect = simplexml_load_file($rest_domain.'/api/'.$rest_function.'/?'.$postArgs);
        $pardotArray['prospect_id'] = $createProspect->prospect->id;
        if(isset($pardotArray['visitor_id']) && $pardotArray['visitor_id'] != "")
        {
            $this->assignProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray);
        }
        //echo json_encode($pardotArray);
    }

    public function updateProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray) 
    {
        $pardotArray['isnew'] = false;
        $pardotArrayEmail = $pardotArray['email'];
        $rest_function = 'prospect/version/4/do/update/id/'.$pardotArray['prospect_id'];

//Create the post arguments
        $pardot_string = "";
        foreach ($pardotArray as $key=>$value) 
        { 
            $pardot_string .= $key.'='.$value.'&';
        }

        $postArgs = $pardot_string.'api_key='.$pardot_api_key.'&user_key='.$pardot_user_key;
        //echo $postArgs;
        //$postArgs = $pardot_string.'api_key='.$pardot_api_key.'&user_key='.$pardot_user_key;
        $update = simplexml_load_file($rest_domain.'/api/'.$rest_function.'/?'.$postArgs);
        //$this->assignProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray);
    }

    public function assignProspect($rest_domain, $pardot_user_key, $pardot_api_key, $pardotArray)
    {
        //echo 'hello';
        //exit;
        $rest_function = 'visitor/version/4/do/assign/id/'. $pardotArray['visitor_id'];
        
        $postArgs = 'prospect_id='.$pardotArray['prospect_id'].'&api_key='.$pardot_api_key.'&user_key='.$pardot_user_key;
        //echo $postArgs;
        $finalReturn = simplexml_load_file($rest_domain.'/api/'.$rest_function.'/?'.$postArgs);
        //echo json_encode($pardotArray);
        //echo json_encode(array('post' => $this->executeCurl($rest_domain, $rest_function, $postArgs, $pardotArray), 'function' => 'assignProspect'));
    }

    public function executeCurl($rest_domain, $rest_function, $postArgs, $pardotArray) 
    {

// Pardot's REST web service
        $url = $rest_domain.'/api/'.$rest_function.'/?'.$postArgs; 

// Initiate the curl session
        $curl = curl_init($url); 

// Use an HTTP POST 
        curl_setopt($curl, CURLOPT_POST, true); 

// We don't want to return the headers, just the response 
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs); 

// Make the REST call and close connection
        $response = curl_exec($curl); 
        curl_close($curl);
        return $response;
    }


}
