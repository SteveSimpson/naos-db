<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Naos DB';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>NAOS DB</h1>

        <p class="lead">The easy way to configure Nagios.</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to('location')?>" >Configure Nagios with Naos DB</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Locations</h2>

                <p>First, configure the geographic location of your networks.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['location/index'])?>" >Locations &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Networks</h2>

                <p>Next, configure your networks.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['network/index'])?>">Networks &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Hosts</h2>

                <p>Then add hosts.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['host/index'])?>">Hosts &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
