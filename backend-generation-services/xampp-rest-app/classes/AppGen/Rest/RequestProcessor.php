<?php

namespace AppGen\Rest;

require_once(dirname(dirname(__FILE__))."/Settings/Settings.php");
require_once(dirname(dirname(__FILE__))."/Handlers/ResponseHeadersHandler.php");
require_once(dirname(__FILE__)."/AccessVerifier.php");
require_once(dirname(__FILE__)."/ResponseProcessor.php");
require_once(dirname(__FILE__)."/Data/Models/RestRequestConfig.php");

use AppGen\Rest\AccessVerifier;
use AppGen\Rest\ResponseProcessor;
use AppGen\Settings\Settings;
use AppGen\Handlers\ResponseHeadersHandler;
use AppGen\Rest\Data\Models\RestRequestConfig;

class RequestProcessor {
    private $params;
    private $data;
    private $info;
    private $request_config;

    public function __construct($params = array(), $data = array()){
        $this->params = $params;
        $this->request_config = new RestRequestConfig($params,$data);
        $this->data = $data;
        $this->info['version'] = Settings::settings()['system']['version'];
        $this->info['hostname'] = $_SERVER['HTTP_HOST'];
        $this->info['request'] = $this->request_config;
        if(Settings::settings()['system']['rest_enabled']){
            $this->process();
        }else{
            $this->response(false,"This show is not configured to allow API access. Please contact the technical team for enabling API access for this show");
        }
    }

    private function process(){
        $verification = new AccessVerifier($this->params,Settings::settings()['system']['version']);
        if($verification->success === true){
            if(strlen($this->request_config->entity_name) > 0 ){
                $this->execute_rest_call($this->request_config,$verification->info['user']);
            }else{
                $this->info = array_merge($this->info,$verification->info);
                $this->response($verification->success,$verification->message);
            }
        }else{
            $this->response($verification->success,$verification->message);
        }
    }

    private function response($status, $message, $response = "", $content_type = 'json'){

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

    private function execute_rest_call(RestRequestConfig $request_config, array $user){
        $response_processor = new ResponseProcessor($request_config,$user);
        $response = $response_processor->get_response();
        $response['info'] = array_merge($this->info,$response['info']);
        $this->response($response_processor->success,$response_processor->message,$response);
    }


}
?>