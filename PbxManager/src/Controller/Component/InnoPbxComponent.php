<?php
App::uses('Component','Controller');
App::uses('Array2Xml', 'Lib');
App::uses('InnoPbx', 'Lib');

// dummy classes to map SOAP results to (really would love to use namespaces here...)
// you can add methods and variables to these classes as needed
class innoUserInfo { };
class innoCallInfo { };
class innoAnyInfo { };
class innoGroup { };
class innoNo { };
class innoInfo { };

/**
 * Class to handle PBX SOAP calls
 * 
 * @author Michael Müller <development@reu-network.de>
 */

class InnoPbxComponent extends Component {

	protected $inno;
	
	public function __construct($config)
	{
		Configure::load("soap_config");
		$wsdl = Configure::read("soap.wsdl");
		
		$options = array(
			'proxy_host' => Configure::read("proxy.host"),
			'proxy_port' => Configure::read("proxy.port"),
			'proxy_login' => Configure::read("proxy.login"),
			'proxy_password' => Configure::read("proxy.password"),
			'classmap' => array("UserInfo" => "innoUserInfo",
				"CallInfo" => "innoCallInfo",
				"AnyInfo" => "innoAnyInfo",
				"Group" => "innoGroup",
				"No" => "innoNo",
				"Info" => "innoInfo")
		);
		
		$server = Configure::read("soap.server");
		$soapUser = Configure::read("soap.login");
		$soapPasswd = Configure::read("soap.login");
		
		$cn = (array_key_exists("cn", $config)) ? $config['cn'] : null;
		
		$this->inno = new InnoPbx($server, $soapUser, $soapPasswd, $cn, $options, $wsdl); 
		if ($this->inno->getKey() == 0) 
			die("failed to login to PBX");
	}
	
	public function setRecordingConf($cn, $number, $enable)
	{
		
	}
	
	public function getRecordingStatus($cn)
	{
		
	}
}