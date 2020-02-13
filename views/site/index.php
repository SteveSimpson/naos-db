<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Naos DB';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>NAOS DB</h1>

        <p class="lead">The easy way to configure Nagios.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Locations</h2>

                <p>First, configure the geographic location of your networks.</p>

                <p><a class="btn btn-primary" href="<?= Url::to(['location/index'])?>" >Locations &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Networks</h2>

                <p>Next, configure your networks.</p>

                <p><a class="btn btn-primary" href="<?= Url::to(['network/index'])?>">Networks &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Hosts</h2>

                <p>Then add hosts.</p>

                <p><a class="btn btn-primary" href="<?= Url::to(['host/index'])?>">Hosts &raquo;</a></p>
            </div>
        </div>
        
                <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <h2>PPS</h2>

                <p>Map Firewall Confis / Make a Detailed PPS.</p>

                <p><a class="btn btn-primary" href="<?= Url::to(['pps/index'])?>" >Firewall &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Software</h2>

                <p>Track Software Applications.</p>

                <p><a class="btn btn-primary" href="<?= Url::to(['software/index'])?>">Software &raquo;</a></p>
            </div>
			<div class="col-lg-2"></div>
        </div>

    </div>
</div>
