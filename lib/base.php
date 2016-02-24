<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuan
 * Date: 18/2/16
 * Time: 6:14 PM
 */

global $DEBUG;
$DEBUG = false;

ToroHook::add("error404", function () {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array("error" => "Please check against our API at https://github.com/yuan3y/cms-backend"), JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT); //error message, however, this conflicts with any other 404 errors.
});


class ArrayValue implements JsonSerializable
{
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function jsonSerialize()
    {
        return $this->array;
    }
}

function _sanitize($data)
{
    if (!isset($data)) $data = '';
    _cleanInputs($data);
    return $data;
}

/**
 * Modifies a string to remove all non ASCII characters and spaces.
 * http://slugify.net/libraries
 */
function _slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    // transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    // lowercase
    $text = strtolower($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}


function _response($data, $status = 200, $content_type = "application/json")
{
    /*header("HTTP/1.1 " . $status . " " . _requestStatus($status));
    return json_encode($data);*/
    ToroHook::add("$status", function () use (&$status, &$data, &$content_type) {
        header("HTTP/1.1 " . $status . " " . _requestStatus($status));
        header("Content-type: " . $content_type);
        echo json_encode($data);
    });
    ToroHook::add("after_request", function () use (&$status) {
        ToroHook::fire("$status");
        if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) {
            echo "\n\r<br>\n\r";
            var_dump($_SERVER);
        }
    });
}

function _cleanInputs($data = '')
{
    $clean_input = array();
    if (is_array($data)) {
        foreach ($data as $k => $v) {
            $clean_input[$k] = _cleanInputs($v);
        }
    } else {
        $clean_input = trim(strip_tags($data));
    }
    return $clean_input;
}

function _set_default()
{
    $arg_list = func_get_args();
    $defaultArray = array();
    foreach ($arg_list as $arg) {
        $defaultArray[$arg] = '';
    }
    if ($_POST != null)
        return array_merge($defaultArray, $_POST);
    else
        return array_merge($defaultArray, $_GET);
}


function _requestStatus($code)
{
    $status = array(
        /*		200 => 'OK',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                500 => 'Internal Server Error',*/
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Not authoritative',
//204 =>	'No content',
//205 =>	'Reset',
//206 =>	'Partial',
//300 =>	'Multiple choices',
//301 =>	'Moved permanently',
//302 =>	'Moved temporarily',
//303 =>	'See other',
//304 =>	'Not modified',
//305 =>	'Use proxy.',
        400 => 'Bad Request',
        401 => 'Unauthorized',
//402 =>	'Payment required',
//403 =>	'Forbidden',
        404 => 'Not found',
        405 => 'Bad Method', //e.g. POST method only, but received an GET method
        406 => 'Not acceptable',
//407 =>	'Proxy authentication required',
        408 => 'Client Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length required',
        412 => 'Precondition failed',
        413 => 'Entity too large',
        414 => 'Request too long',
        415 => 'Unsupported type',
        500 => 'Internal error',
        501 => 'Not implemented',
        502 => 'Bad Gateway',
        503 => 'Unavailable',
        504 => 'Gateway timeout',
        505 => 'Version not supported'
    );
    return ($status[$code]) ? $status[$code] : $status[500];
}