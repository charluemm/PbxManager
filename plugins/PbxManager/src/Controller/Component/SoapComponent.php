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
	public function findUserConfig($cn = null, $h323 = null, $e165 = null)
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
			//$user->addAttribute("config", "true");
			$show = $this->soapClient->Admin($result->asXML());
		}
		return $show;
	}
	
	/**
	 * get recording status from user
	 *
	 * @param string $userCN the user identifier
	 * @return array $userinfo array of user parameters
	 */
	public function getRecordingStatus($number)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$userConf = $this->findUserConfig(null, null, $number);
		$userConf = new \SimpleXMLElement($userConf);
		$recConf = $userConf->user->phone->rec;
		$return = array();
		
		$return['user_number'] = $number;
		$return['username'] = (string)$userConf->user['cn'];
		$return['number'] = (string)$recConf['e164'];

		// set return attributes
		$mode  = (string) $recConf['mode'];
		$twoWayMedia = (string)$recConf['recv'];
		$autoconnect = (string)$recConf['ac'];
		
		$return['recording'] = ($mode === "transparent" && $twoWayMedia === "1" && $autoconnect === "1");
				
		return $return;
	}
	
	public function enableRecording($number)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$showConf = new \SimpleXMLElement($this->findUserConfig(null, null, $number));
		
		/** @var $recConf \SimpleXMLElement */
		$recConf = $userConf->user->phone->rec;
		$recConf['mode'] = "transparent";
		$recConf['recv']= 0;
		$recConf['ac'] = 0;
		
		var_dump($userConf->asXML());
		//$result = $this->soapClient->Admin($userConf->asXML());
		
				var_dump($result);
		die();
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