<?php

function testing()
{
    return $json = [
        'code' => 200,
        'status' => "Ok",
        'messgae' => "kampret"
    ];
}

if ( ! function_exists('b_json_response'))
{
    function b_json_response($success = false, $status = 403, $message = "No Access", $data = array())
    {
        $json_response = array(
            "success" => (bool) $success,
            "status" => (int) $status,
            "message" => (string) $message,
        );

        if(is_array($data)){
            if(!empty($data)){
                $json_response["data"] = $data;
            }
        }

        return $json_response;
    }
}

if ( ! function_exists('b_pagination_response'))
{
    function b_pagination_response($total_data = 0, $total_page = 0, $page = 0, $limit = 0, $offset = 0)
    {
        $json_response = array(
            "total_data" => (int)$total_data,
            "total_page" => (int)$total_page,
            "page" => (int)$page,
            "limit" => (int)$limit,
            "offset" => (int)$offset,
        );

        return $json_response;
    }
}


if ( ! function_exists('offset'))
{
    function offset($limit = 0, $page = 1)
    {
        $offset = (int)($page > 1)?($page * $limit) - $limit : 0;
        return $offset;
    }
}


if ( ! function_exists('total_page'))
{
	function total_page($limit = 0, $total_data = 0)
    {
		$hasil = 1;
		if ($limit > 0){
			$hasil = ceil($total_data/$limit);
		}
		return $hasil;
	}
}

if ( ! function_exists('b_core'))
{
	function b_core()
    {
        $code = '
                $limit      = $request->limit != null ? $request->limit: 10;
                $page       = $request->page != null ? $request->page : 1;
                $offset     = offset($limit, $page);
                $total_page = total_page($limit, $total_data);
                $pagination = b_pagination_response($total_data, $total_page, $page, $limit, $offset);';

        return $code;
	}
}


if ( ! function_exists('http_status_code'))
{
	function http_status_code($code = '')
    {
		$code 				= (string)$code;
		$hasil 				= 'Internal Server Error';

		switch ($code) {
			case '100':
				$hasil 		= 'Continue';
				break;
			case '101':
				$hasil 		= 'Switching Protocols';
				break;
			case '102':
				$hasil 		= 'Processing';
				break;
			case '103':
				$hasil 		= 'Early Hints';
				break;
			case '200':
				$hasil 		= 'OK';
				break;
			case '200':
				$hasil 		= 'OK';
				break;
			case '201':
				$hasil 		= 'Created';
				break;
			case '202':
				$hasil 		= 'Accepted';
				break;
			case '203':
				$hasil 		= 'Non-Authoritative Information';
				break;
			case '204':
				$hasil 		= 'No Content';
				break;
			case '205':
				$hasil 		= 'Reset Content';
				break;
			case '206':
				$hasil 		= 'Partial Content';
				break;
			case '207':
				$hasil 		= 'Multi-Status';
				break;
			case '208':
				$hasil 		= 'Already Reported';
				break;
			case '226':
				$hasil 		= 'IM Used';
				break;
			case '300':
				$hasil 		= 'Multiple Choices';
				break;
			case '301':
				$hasil 		= 'Moved Permanently';
				break;
			case '302':
				$hasil 		= 'Found';
				break;
			case '303':
				$hasil 		= 'See Other';
				break;
			case '304':
				$hasil 		= 'Not Modified';
				break;
			case '305':
				$hasil 		= 'Use Proxy';
				break;
			case '306':
				$hasil 		= 'Switch Proxy';
				break;
			case '307':
				$hasil 		= 'Temporary Redirect';
				break;
			case '308':
				$hasil 		= 'Permanent Redirect';
				break;
			case '400':
				$hasil 		= 'Bad Request';
				break;
			case '401':
				$hasil 		= 'Unauthorized';
				break;
			case '402':
				$hasil 		= 'Payment Required';
				break;
			case '403':
				$hasil 		= 'Forbidden';
				break;
			case '404':
				$hasil 		= 'Not Found';
				break;
			case '405':
				$hasil 		= 'Method Not Allowed';
				break;
			case '406':
				$hasil 		= 'Not Acceptable';
				break;
			case '407':
				$hasil 		= 'Proxy Authentication Required';
				break;
			case '408':
				$hasil 		= 'Request Timeout';
				break;
			case '409':
				$hasil 		= 'Conflict';
				break;
			case '410':
				$hasil 		= 'Gone';
				break;
			case '411':
				$hasil 		= 'Length Required';
				break;
			case '412':
				$hasil 		= 'Precondition Failed';
				break;
			case '413':
				$hasil 		= 'Payload Too Large';
				break;
			case '414':
				$hasil 		= 'URI Too Long';
				break;
			case '415':
				$hasil 		= 'Unsupported Media Type';
				break;
			case '416':
				$hasil 		= 'Range Not Satisfiable';
				break;
			case '417':
				$hasil 		= 'Expectation Failed';
				break;
			case '418':
				$hasil 		= "I'm a teapot";
				break;
			case '421':
				$hasil 		= 'Misdirected Request';
				break;
			case '422':
				$hasil 		= 'Unprocessable Entity';
				break;
			case '423':
				$hasil 		= 'Locked';
				break;
			case '424':
				$hasil 		= 'Failed Dependency';
				break;
			case '425':
				$hasil 		= 'Too Early';
				break;
			case '426':
				$hasil 		= 'Upgrade Required';
				break;
			case '428':
				$hasil 		= 'Precondition Required';
				break;
			case '429':
				$hasil 		= 'Too Many Requests';
				break;
			case '431':
				$hasil 		= 'Request Header Fields Too Large';
				break;
			case '451':
				$hasil 		= 'Unavailable For Legal Reasons';
				break;
			case '500':
				$hasil 		= 'Internal Server Error';
				break;
			case '501':
				$hasil 		= 'Not Implemented';
				break;
			case '502':
				$hasil 		= 'Bad Gateway';
				break;
			case '503':
				$hasil 		= 'Service Unavailable';
				break;
			case '504':
				$hasil 		= 'Gateway Timeout';
				break;
			case '505':
				$hasil 		= 'HTTP Version Not Supported';
				break;
			case '506':
				$hasil 		= 'Variant Also Negotiates';
				break;
			case '507':
				$hasil 		= 'Insufficient Storage';
				break;
			case '508':
				$hasil 		= 'Loop Detected';
				break;
			case '508':
				$hasil 		= 'Loop Detected';
				break;
			case '510':
				$hasil 		= 'Not Extended';
				break;
			case '511':
				$hasil 		= 'Network Authentication Required';
				break;
			default:
				$hasil 		= 'Internal Server Error';
				break;
		}

		return $hasil;
	}
}