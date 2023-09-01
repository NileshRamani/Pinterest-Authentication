<?php
/**
 * Redirect to pinterest site with application information for auth 2.0 verification,
 * Redirect to specified 'redirect_url' path if successfully authenticated or not, with respective response
 * 
 * @Auther: Nilesh Ramani
 * @Contact: 
 			- https://github.com/NileshRamani
			- +91 97241 16546
 */ 
$param = array(
			'response_type' => 'code', // STATIC CODE
			'client_id' => 'PINTEREST_APPLICATION_CLIENT_ID', // CLIENT ID
			'state' => 'RANDOM_CODE', // RANDOM TEXT TO VERIFY THE APPLICATION RETURN
			'scope' => 'read_public,write_public,read_relationships,write_relationships', // APPLICATOIN ACCESS RIGHTS
			'redirect_uri' => 'RETURN_REDIRECT_URL' // RETURN URL PATH
		);

header('Location: https://api.pinterest.com/oauth/?'.http_build_query($param));