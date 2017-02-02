<?

post_lead($_POST['text-854'],$_POST['your-name'],$_POST['your-email'],$_POST['tel-956'],'','','','','','False');


function post_lead($firstName,$lastName,$email,$phone1,$phone2,$address,$city,$interest,$freetext,$allowAds)
{
    $crlf = chr(13) . chr(10);
    try {
		$fields = array(
		'supplier' => get_host(),
        'referer'=>$_SERVER['HTTP_REFERER'],
		'firstName' => $firstName, 
		'lastName' => $lastName,
		'email' => $email,
		'phone1' => $phone1,
		'phone2' => $phone2,
		'address' => $address,
		'city' => $city,
		'interest' => 'Interest:' . $crlf  . $interest . $crlf . 'Comment:' . $crlf . $freetext,
        'allowAds'=>$allowAds
		);
		
		$response = http_post_lite('https://www.burlingtonenglish.com/BESMZ/LeadImport?token=71062917-0320-49c9-ba6d-1d3ebcc58826', $fields);
			if(strtolower($response)!='ok')
			throw new Exception($response);
		
	}
	catch (Exception $e) {
		error_log($e->getMessage());
		mail('elirany@burlington.co.il,ayal@burlington.co.il', 'Post Lead Error', $e->getMessage());
	}
}

function http_post_lite($url, $data, $headers=null) {
	
	$data = http_build_query($data);	
	$opts = array('http' => array('method' => 'POST', 'content' => $data));
	
	if($headers) {
		$opts['http']['header'] = $headers;
	}
	$st = stream_context_create($opts);
	$fp = fopen($url, 'rb', false, $st);
	
	if(!$fp) {
		return false;
	}
	return stream_get_contents($fp);
}

function get_host() {
	if ($host = $_SERVER['HTTP_X_FORWARDED_HOST'])
    {
        $elements = explode(',', $host);

        $host = trim(end($elements));
    }
    else
    {
        if (!$host = $_SERVER['HTTP_HOST'])
        {
            if (!$host = $_SERVER['SERVER_NAME'])
            {
                $host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
            }
        }
    }

    // Remove port number from host
    //$host = preg_replace('/:\d+$/', '', $host);

    return trim($host);
}





?>