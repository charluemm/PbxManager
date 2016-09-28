<?php

namespace PbxManager\Controller\Component;

use Cake\Controller\Component;
use PbxManager\lib\Array2XML;

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
	 * @param string $number the agent phone
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
	
	/**
	 * enable pbx recording
	 *
	 * @param int $number agent phone
	 * @param int $supervisor supervisor phone
	 * @throws \Exception if soap client is not configured
	 * @return boolean true, if sucessfull
	 */
	public function enableRecording($number, $supervisor)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$userConf = new \SimpleXMLElement($this->findUserConfig(null, null, $number));
		
		// set recording settings
		$recConf = $this->setRecordingConf($userConf, true, $supervisor);
		$result = $this->soapClient->Admin($recConf);
		
		// check result
		if(trim($result) == "<ok/>")
			return true;
		else
			return false;
	}
	
	/**
	 * disable pbx recording 
	 * 
	 * @param int $number agent phone
	 * @param int $supervisor supervisor phone
	 * @throws \Exception if soap client is not configured
	 * @return boolean true, if sucessfull
	 */
	public function disableRecording($number, $supervisor)
	{
		if(empty($this->soapClient))
		{
			throw new \Exception("SoapClient is not configured. Check SOAP parameters in soap_config.php");
		}
		
		$userConf = new \SimpleXMLElement($this->findUserConfig(null, null, $number));
		
		// set recording settings
		$recConf = $this->setRecordingConf($userConf, false, $supervisor);
		$result = $this->soapClient->Admin($recConf);
		
		// check result
		if(trim($result) == "<ok/>")
			return true;
		else
			return false;
	}
	
	/**
	 * create recording conf xml
	 *  
	 * @param UserInfo $xmlConf agents userconfig
	 * @param boolean $enable enable or disable
	 * @param int $number supervisor phone number
	 */
	private function setRecordingConf($xmlConf, $enable, $number = null)
	{
		if($enable)
		{
			$mode = "transparent";
			$recv = 1;
			$ac = 1;
		}
		else
		{
			$mode = "off";
			$recv = 0;
			$ac = 0;
		}
		
		/** @var $recConf \SimpleXMLElement */
		$recConf = $xmlConf->user->phone->rec;
		$recConf['mode'] = $mode;
		$recConf['recv']= $recv;
		$recConf['ac'] = $ac;
		$recConf['number'] = $number;
		
		// convert to array
		$arrayConf = json_decode(json_encode(simplexml_load_string($xmlConf->asXML())),true);
		$xml = Array2XML::createXML("modify", $arrayConf);
		return $xml->saveXML();
	}
}