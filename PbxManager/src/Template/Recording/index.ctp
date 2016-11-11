<h2>Recording-/Mithörfunktion</h2>

<div class="box">
    <div class="ym-grid">
        <div class="ym-g50 ym-gl">
        <?php 
            echo $this->Form->create('select');
            echo $this->Form->input('supervisorPhone', array('label' => 'Durchwahl Supervisor', 'placeholder' => 'Durchwahl Supervisor'));
            echo $this->Form->input('agentPhone', array('label' => 'Durchwahl Agent', 'placeholder' => 'Durchwahl Agent'));
            echo $this->Form->submit('Agent Infos anzeigen', array('div' => false, 'name' => 'show', 'class' => 'right1'));
            echo $this->Form->submit('aktivieren', array('div' => false, 'name' => 'enable', 'class' => 'right1')); 
            echo $this->Form->submit('deaktivieren', array('div' => false, 'name' => 'disable'));
            echo $this->Form->end();
        ?>
        </div>

        <div class="ym-g50 ym-gr">
            <div class="ym-gbox-right">
            <?php 
                if (isset($userinfo))
                { 
                    echo "<h3>Agent ".$userinfo['username']."</h3>"; 
                    if($userinfo['recording'])
                        echo "<p>Mithören ist <strong>aktiviert</strong> für Supervisor <strong>".$userinfo['number']."</strong>.</p>";
                    else
                        echo "<p>Mithören ist <strong>nicht aktiviert</strong>.</p>";
                    echo "<br/>";
                }
                else
                {
                    echo "<p>Bitte füllen Sie das Formular vollständig aus.</p>";
                }
            ?>
            </div>
        </div>
    </div>
</div>