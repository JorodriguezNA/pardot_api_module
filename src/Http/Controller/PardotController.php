<?php namespace Pardot\PardotapiModule\Http\Controller;

use Pardot\PardotapiModule\Instance\Form\InstanceFormBuilder;
use Pardot\PardotapiModule\Instance\Table\InstanceTableBuilder;
use Pardot\PardotapiModule\Instance\Contract\InstanceRepositoryInterface;
use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\EncryptedFieldType\EncryptedFieldTypePresenter;
use Illuminate\Support\Facades\DB;

class PardotController extends PublicController
{


	public function createprospect($slug, \Illuminate\Http\Request $request, \Pardot\PardotapiModule\PardotapiModule $pardotAPI, InstanceRepositoryInterface $instance)
	{
		header("Access-Control-Allow-Origin: *");
		$instanceInfo = DB::table('pardotapi_instances')->where('slug', $slug)->first();
		$instanceInfo->user_password = decrypt($instanceInfo->user_password);
		$instanceInfo->user_key = decrypt($instanceInfo->user_key);
		//$thisInstance = $instance->findbyslug(1);

		$pardotConnection = array('email' => $instanceInfo->account_email, 'pw' => $instanceInfo->user_password, 'user_key' => $instanceInfo->user_key, 'rest_domain' => $instanceInfo->rest_domain);

	    $getAPIKey = "https://pi.pardot.com/api/login/version/4?email=".$pardotConnection['email']."&password=".$pardotConnection['pw']."&user_key=".$pardotConnection['user_key'];

	    $xml = simplexml_load_file($getAPIKey);
	    $pardotConnection['api_key'] = $xml->api_key;
	    //echo json_encode(array('pardot_connection' => $pardotConnection));
	    //exit;

	    $pardotArray = array();
	 
	    //Checking for First Name and storing in array
	    if (isset($_REQUEST['first_name'])) {
	     $pardotArray['first_name'] = trim($_REQUEST['first_name']);
	    }
	     
	    //Checking for Last Name and storing in array
	    if (isset($_REQUEST['last_name'])) {
	     $pardotArray['last_name'] = trim($_REQUEST['last_name']);
	    }
	     
	    //Checking for Email Address and storing in array
	    if (isset($_REQUEST['email'])) {
	     $pardotArray['email'] = trim($_REQUEST['email']);
	    }
	     
	    //Checking for Company and storing in array
	    if (isset($_REQUEST['company'])) {
	     $pardotArray['company'] = trim($_REQUEST['company']);
	    }

	    if (isset($_REQUEST['visitor_id'])) {
	     $pardotArray['visitor_id'] = trim($_REQUEST['visitor_id']);
	    }
	    
	    if (isset($_REQUEST['brand'])) {
	     $pardotArray['Brand'] = trim($_REQUEST['brand']);
	    }

	    $pardotAPI->checkProspect('https://pi.pardot.com', $pardotConnection['user_key'], $pardotConnection['api_key'], $pardotArray);

	    //$pardotArray['api_key'] = $pardotConnection['api_key'];
	    //echo 'hello <br/><br />';
	    //echo json_encode($pardotArray);]
	    echo json_encode(array('success' => 'true'));
	    exit;
		//return json_encode(array('message' => 'HELLO', 'instance' => $instanceInfo));
	}
}