<?php

namespace PbxManager\Controller\Component;

use Cake\Controller\Component;

/**
 * Class to handle SOAP calls
 * 
 * @author Michael Müller <development@reu-network.de>
 * @author David Howon <howon.david@gmail.com>
 *
 */
class SoapComponent extends Component {
	
	/** @var \SoapClient */
	private $soapClient;
	
	public function initialize(array $config)
	{	
		parent::initialize($config);
		if(array_key_exists('url', $config) && array_key_exists('options', $config))
		{
			$url = $config['url'];
			$options = $config['options'];
			
			if(!empty($url))
				$this->soapClient = new \SoapClient($url, $options);
		}
	}
	
	/**
	 * 
	 * @param string $cn
	 * @param string $h323
	 * @param string $e165
	 * @return UserInfoArray
	 */
	public function findUser($cn = null, $h323 = null, $e165 = "16")
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		// search user
		$list = $this->soapClient->FindUser(true, true, true, true, $cn, $h323, $e165, 1, false, false);
		$show = array();
		
		foreach ($list as $user)
		{
			$cn = $user->cn;
			$result = new \SimpleXMLElement("<show />");
			$user = $result->addChild("user");
			$user->addAttribute("cn", $cn);
			$user->addAttribute("config", "true");
			$show = $this->soapClient->Admin($result->asXML());
		}
		return $show;
	}
	
	/**
	 * get user info from soap server
	 *
	 * @param string $userCN the user identifier
	 * @return array $userinfo array of user parameters
	 */
	public function getUserInfo($userCN)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$result = "";
		$result = $this->soapClient->__call('UserLocalNum', array('user' => null, 'num' => null));
		//$result = $this->soapClient->getUserInfo($userCN);
		var_dump($result);
		
		if(is_soap_fault($result))
		{
			return " Fehlercode: $result->faultcode | Fehlerstring: $result->faultstring";
		}
		else
		{
			return $result;
		}
	}
	
	public function enableRecording($userCN)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$result = "";
		
		return true;
	}
	
	public function disableRecording($userCN)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$result = "";
		
		return true;
	}
}