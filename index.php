<?php
class txFunds{
	private $user = 'apitest@ipayoptions.com';	
	private $pass = '1q2w3e4r5t6y';
	private $api_url = 'http://txfunds.uat.ipayoptions.com/api.php';
	public $cookie = 'cookie.txt';
	
	public function login(){
		
		$request['act'] = 'login' ;
		$request['email'] = $this->user;
		$request['password'] = $this->pass;		
		
		$ch = curl_init($this->api_url);
		$opts[CURLOPT_POST] = true;
		$opts[CURLOPT_POSTFIELDS] = http_build_query($request);
		$opts[CURLOPT_RETURNTRANSFER] = true;		
		curl_setopt_array($ch,$opts);
		$response = curl_exec($ch);
		$response = json_decode($response,1);
		curl_close($ch);
		return $response;
	}
	
	public function getData($loginid){
		
		$request['act'] = 'usercheck';
		$request['email'] = $this->user;
		//$request['mobile'] = '';
		//$request['country'] = 'AU';
		$request['loginid'] = $loginid;
		$ch = curl_init($this->api_url);
		$opts[CURLOPT_POST] = true;
		$opts[CURLOPT_POSTFIELDS] = http_build_query($request);
		$opts[CURLOPT_RETURNTRANSFER] = true;
		curl_setopt_array($ch,$opts);
		$response = curl_exec($ch);
		$response = json_decode($response,1);
		/*print_r($response);*/
		curl_close($ch);
		return $response;
	}

}


$myData = new txFunds();
$login_result = $myData->login();
//print_r($login_result);

$get_data = $myData->getData($login_result['data']['loginid']);
//print_r($get_data);
?>
	<html>
		<head></head>
		<body style="width:400px;margin:0 auto;">
			<h1>User Data</h1>
			<table style="width:400px;margin:0 auto;">
				<tr>
					<td>User ID : </td>
					<td><?php echo $login_result['data']['userid'];?></td>
				</tr>
				<tr>
					<td>Firstname : </td>
					<td><?php echo $login_result['data']['firstname'];?></td>
				</tr>
				<tr>
					<td>Lastname : </td>
					<td><?php echo $login_result['data']['lastname'];?></td>
				</tr>
				<tr>
					<td>MSG : </td>
					<td><?php echo $get_data['msg'];?></td>
				</tr>
				<tr>
					<td>Status : </td>
					<td><?php echo $get_data['data']['status'];?></td>
				</tr>	
			</table>
		</body>
	</html>
