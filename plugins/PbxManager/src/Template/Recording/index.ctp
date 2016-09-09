<h1>Recording-/Mithörfunktion</h1>

<div style="width: 48%; float:left; padding-left: 1%">
<h3>Agent auswählen</h3>
<?php 
	echo $this->Form->create();
	echo $this->Form->input('agentPhone', array('label' => false, 'placeholder' => 'Durchwahl Agent'));
	echo $this->Form->submit('Auswählen');
	echo $this->Form->end();
?>
</div>

<div style="width: 49%; float:left; padding-left: 2%">
<h3>Agent Info</h3>
<p>Hier steht die Agent Info</p>
<?php
echo $this->Html->link("aktivieren", array('controller' => 'recording', 'action' => 'enable'));
echo " | ";
echo $this->Html->link("deaktivieren", array('controller' => 'recording', 'action' => 'disable'));
?>
</div>