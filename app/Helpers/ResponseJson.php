<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

if(!function_exists('sendResponse')){
function sendResponse($result, $message, $code =200)
{
    return Response::json(['success'=> $code==200, 'data'=> $result, 'message'=> $message], $code);
}
}

if(!function_exists('sendError')){
function sendError($error, $code =400): JsonResponse
{
    return Response::json(['success'=> $code==200, 'data'=> null, 'message'=> $error], $code);
}
}


