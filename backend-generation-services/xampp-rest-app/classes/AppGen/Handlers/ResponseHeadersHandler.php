<?php

namespace AppGen\Handlers;

class ResponseHeadersHandler{

    public static function set_response_header($type){
         ob_clean();
        header_remove();
        switch($type){
            case 'text':
                header("Content-type: application/dxf; charset=utf-8");
                break;
            case 'text':
                header("Content-type: text/plain; charset=utf-8");
                break;
            case 'svg':
                header("Content-type: image/svg+xml; charset=utf-8");
                break;
            case 'html':
                header("Content-type: text/html; charset=utf-8");
                break;
            case 'json':
            default:
                header("Content-type: application/json; charset=utf-8");
            break;
        }
        http_response_code(200);
    }
}


?>