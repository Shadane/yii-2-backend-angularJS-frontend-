<?php

use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"ng-app="app">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Angular Yii</title>
        <?php $this->head() ?>
    </head>
    <body ng-controller="MainController">
        <?php $this->beginBody() ?>
        <div class="wrap">
            <nav class="navbar-inverse navbar-fixed-top navbar" role="navigation"  bs-navbar>
                <div class="container">
                    <div class="navbar-header">
                        <button ng-init="navCollapsed = true" ng-click="navCollapsed = !navCollapsed" type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span></button>
                                    <a class="navbar-brand navbar-left" href="#/">Размещение объявлений</a>
                    </div>
                    <div ng-class="!navCollapsed && 'in'" ng-click="navCollapsed = true" class="collapse navbar-collapse" >
                        <ul class="navbar-nav text-center nav">
                            <li data-match-route="/$">
                                <a href="#/">Приложение</a>
                            </li>
                            <li data-match-route="/about">
                                <a href="#/about">О приложении</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container col-lg-5 col-md-8 col-sm-8 col-lg-offset-3 col-md-offset-1 col-sm-offset-1"> 
                <div ng-view>
                </div>
            </div>


            <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
