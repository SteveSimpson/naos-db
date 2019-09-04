<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$user = "?";

if (isset($_SERVER['PHP_AUTH_USER'])) {
    $user = $_SERVER['PHP_AUTH_USER'];
}

?>

<?php $this->beginPage() ?>
<HTML lang="<?= Yii::$app->language ?>">
<HEAD>
<link rel="shortcut icon" href="/nagios/images/favicon.ico" type="image/ico">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

<LINK REL='stylesheet' TYPE='text/css' HREF='nag/extinfo.css'>
</HEAD>
<BODY CLASS='tac' marginwidth=2 marginheight=2 topmargin=0 leftmargin=0 rightmargin=0>
<?php $this->beginBody() ?>
<?php /*
<table border=0 width=100% cellpadding=0 cellspacing=0>
<tr>
<td align=left valign=top width=33%>

<TABLE CLASS='infoBox' BORDER=1 CELLSPACING=0 CELLPADDING=0>
<TR><TD CLASS='infoBox'>
<DIV CLASS='infoBoxTitle'>Naos DB</DIV>
Last Updated: <?=date("D M j H:i:s e Y") ?><BR>
Updated every 90 seconds<br>
Logged in as <i><?= $user ?></i><BR>
</TD></TR>
</TABLE>


</td>
<td align=center valign=top width=33%>
</td>
<td align=right valign=top width=33%>
</td>
</tr>
</table>


*/ ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Naos DB'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

<?php $this->endBody() ?>
</BODY>
</HTML>
<?php $this->endPage() ?>