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
	
	private $soapClient;
	
	public function initialize(array $config)
	{	
		if(array_key_exists('url', $config) && array_key_exists('options', $config))
		{
			$url = $config['url'];
			$options = $config['options'];
			
			if(!empty($url))
				$this->soapClient = new \SoapClient($url, $options);
		}
	}
	
	/**
	 * get user info from soap server
	 *
	 * @param string $userCN the user identifier
	 * @return array $userinfo array of user parameters
	 */
	public function getUserInfo($userCN)
	{
		$result = $this->soapClient->getUserInfo($userCN);
		
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
		$result = "";
		
		return true;
	}
	
	public function disableRecording($userCN)
	{
		$result = "";
		
		return true;
	}
}