<?php
App::uses('Component','Controller');
App::uses('Array2Xml', 'PbxManager.Lib');
App::uses('InnoPbx', 'PbxManager.Lib');

/**
 * Class to handle PBX SOAP calls
 * 
 * @author Michael Müller <development@reu-network.de>
 */

class InnoPbxComponent extends Component {

	protected $inno;
	
	public function __construct(ComponentCollection $collection, $settings = array())
	{
		try
		{
			Configure::load("soap_config");
		}
		catch (Exception $ex)
		{
			Configure::load("PbxManager.soap_config");
		}
		
		$wsdl = Configure::read("soap.wsdl");
		
		$options = array(
			'proxy_host' => Configure::read("proxy.host"),
			'proxy_port' => Configure::read("proxy.port"),
			'proxy_login' => Configure::read("proxy.login"),
			'proxy_password' => Configure::read("proxy.password"),
			'classmap' => array(
				"UserInfo"	=> "InnoUserInfo",
				"CallInfo" 	=> "InnoCallInfo",
				"AnyInfo"	=> "InnoAnyInfo",
				"Group" 	=> "InnoGroup",
				"No"		=> "InnoNo",
				"Info" 		=> "InnoInfo")
		);
		
		$server = Configure::read("soap.server");
		$soapUser = Configure::read("soap.login");
		$soapPasswd = Configure::read("soap.password");
		
		$cn = (array_key_exists("cn", $settings)) ? $settings['cn'] : null;
		
		$this->inno = new InnoPbx($server, $soapUser, $soapPasswd, $cn, $options, $wsdl); 
		if ($this->inno->getKey() == 0) 
			die("failed to login to PBX. session could not be initialized.");
	}
	
	public function poll()
	{
		return $this->inno->Poll($this->inno->getSession());
	}
	
	public function setRecordingConf($cn, $number, $enable)
	{
	}
	
	public function getRecordingStatus($cn)
	{
		
	}
}