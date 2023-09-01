<?php
/**
 * CHECK IF SUCCESSFULLY RETURN TO THE PAGE, IF YES THEN VARIFY RESPONSE AND GET USER INFORMATION
 * 
 * @Auther: Nilesh Ramani
 * @Contact: 
 			- https://github.com/NileshRamani
			- +91 97241 16546
 */

// CHECK IF SUCCESSFULLY RETURN TO THE PAGE, IF YES THEN VARIFY RESPONSE AND GET USER INFORMATION
if(isset($_REQUEST['code']) and !empty($_REQUEST['code'])) {
	$param = array(
				'grant_type' => 'authorization_code', // STATIC CODE FOR AUTHE TOKEN VERIFICATION
				'client_id' => 'PINTEREST_APPLICATION_CLIENT_ID', // CLIENT ID
				'client_secret' => 'PINTEREST_APPLICATION_CLIENT_SECRET', // CLIENT APPLICATION SECRET ID
				'code' => $_REQUEST['code'] // THE RETURN FROM PINTEREST APPLICATION
			);
	$url = 'https://api.pinterest.com/v5/oauth/token';
	
	// NEED TO MAKE POST REQUEST FOR TOKEN AUTHORIZATION
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$returnData = curl_exec($ch); 
	$httpCode = curl_getinfo($ch); 
	curl_close($ch); 
	
	$returnData = json_decode($returnData);
	$accessToken = $returnData->access_token;
	
	// MAKE CALL FOR GET USER INFOMATION USING OFFLINE ACCESS TOKEN
	if(!empty($accessToken)) {
		$url = 'https://api.pinterest.com/v5/me/?fields=id,username,first_name,last_name,url,image[original,small]&access_token='.$accessToken;
		
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returnMyData = curl_exec($ch); 
		$httpCode = curl_getinfo($ch); 
		curl_close($ch); 
		
		$returnMyData = json_decode($returnMyData);
		echo '<table>
				<tr>
					<td>
						<strong>Access Token:</strong> 
					</td>
					<td>
						'.$accessToken.'
					</td>
				</tr>
				<tr>
					<td>
						<strong>Profile ID: </strong>
					</td>
					<td>
						'.$returnMyData->data->id.'
					</td>
				</tr>
				<tr>
					<td>
						<strong>Profile Name: </strong>
					</td>
					<td>
						'.$returnMyData->data->first_name.' '.$returnMyData->data->last_name.'
					</td>
				</tr>
				<tr>
					<td>
						<strong>Profile Username: </strong>
					</td>
					<td>
						'.$returnMyData->data->username.'
					</td>
				</tr>
				<tr>
					<td>
						<strong>Profile URL: </strong>
					</td>
					<td>
						'.$returnMyData->data->url.'
					</td>
				</tr>
				<tr>
					<td>
						<strong>Profile Image: </strong>
					</td>
					<td>
						'.$returnMyData->data->image->small->url.'
					</td>
				</tr>
			</table>';
	}
} else {
	echo "YOU ARE NOT SUCCESSFULLY VARIFIED!";
}
