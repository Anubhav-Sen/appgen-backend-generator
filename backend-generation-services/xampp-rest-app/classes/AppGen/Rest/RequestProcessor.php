<?php

namespace AppGen\Rest;

require_once(dirname(dirname(__FILE__))."/Settings/Settings.php");
require_once(dirname(dirname(__FILE__))."/Handlers/ResponseHeadersHandler.php");
require_once(dirname(__FILE__)."/AccessVerifier.php");
require_once(dirname(__FILE__)."/ResponseProcessor.php");

use AppGen\Rest\AccessVerifier;
use AppGen\Rest\ResponseProcessor;
use AppGen\Settings\Settings;
use AppGen\Handlers\ResponseHeadersHandler;

class RequestProcessor {
    private $params;
    private $vars;
    private $info;

    public function __construct($params = array(), $vars = array()){
        $this->params = $params;
        $this->vars = $vars;
        $this->info['version'] = Settings::settings()['system']['version'];
        $this->info['host_name'] = $_SERVER['HTTP_HOST'];
        if(Settings::settings()['system']['rest_enabled']){
            $this->process();
        }else{
            $this->response(false,"This show is not configured to allow API access. Please contact the technical team for enabling API access for this show");
        }

    }

    private function process(){
        $verification = new AccessVerifier($this->params,Settings::settings()['system']['version']);
        if($verification->success === true){
            // $this->execute_rest_call();
            $this->info = array_merge($this->info,$verification->info);
            $this->response($verification->success,$verification->message);
        }else{
            $this->response($verification->success,$verification->message);
        }
    }

    private function response($status,$message,$response = "",$content_type = 'json'){

        if($response){
            $ret = $response;
        }else{
            $ret['status'] = $status;
            $ret['message'] = $message;
            $ret['info'] = $this->info;
        }

        ResponseHeadersHandler::set_response_header($content_type);

        if(is_array($ret)){
            $ret = json_encode($ret);
        }

        echo $ret;

        exit;
    }

    private function execute_rest_call(){

    }


}
?>