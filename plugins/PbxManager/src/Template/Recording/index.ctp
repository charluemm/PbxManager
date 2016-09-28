<h1>Recording-/Mithörfunktion</h1>

<div style="width: 48%; float:left; padding-left: 1%">
<h3>Agent auswählen</h3>
<?php 
	echo $this->Form->create();
	echo $this->Form->input('agentPhone', array('label' => false, 'placeholder' => 'Durchwahl Agent'));
	echo $this->Form->submit('auswählen');	
	echo $this->Form->end();
?>
</div>

<div style="width: 49%; float:left; padding-left: 2%">
<?php 
if (isset($userinfo))
{ 
	echo "<h3>Agent ".$userinfo['username']."</h3>"; 
	if($userinfo['recording'])
		echo "Mithören ist <strong>aktiviert</strong> für Nummer ".$userinfo['number'].".";
	else
		echo "Mithören ist <strong>nicht aktiviert</strong>.";
	echo "<br/>";
	   
    echo $this->Html->link("aktivieren", array('controller' => 'recording', 'action' => 'enable', $userinfo['user_number']));
    echo " | ";
    echo $this->Html->link("deaktivieren", array('controller' => 'recording', 'action' => 'disable', $userinfo['user_number']));
}
?>
</div>