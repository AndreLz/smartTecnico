<?php
if(Yii::$app->user->isGuest){
    $usuario = "Visitante";
}else{
    $usuario = Yii::$app->user->identity->username;
}
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../web/img/logo.png"/>
            </div>
            <div class="pull-left info">
                <p><?=$usuario?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu','data-widget' => 'tree', ],
                'items' => [

                    ['label' => 'Sistemas Q Smart', 'options' => ['class' => 'header']],
                    [
                        'label' => 'e-Inspection Guider IQC',
                        'icon' => 'fa fa-file-pdf-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'New Part (FPA)', 'icon' => 'fa fa-plus-circle', 'url' => ['/qualidade/create']],
                            ['label' => 'View Parts', 'icon' => 'fa fa-search', 'url' => ['/qualidade/index']],
                        ],
                    ],
                    [
                        'label' => 'e-Inspection Guider OQC',
                        'icon' => 'fa fa-file-pdf-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'New Model', 'icon' => 'fa fa-plus-circle', 'url' => ['/oqcinspection/create']],
                            ['label' => 'View Models', 'icon' => 'fa fa-search', 'url' => ['/oqcinspection/index']],
                        ],
                    ],
                    ['label' => 'IQC Inspections', 'icon' => 'fa fa-search', 'url' => ['/load/index']],
                    [
                        'label' => 'Inspections Control',
                        'icon' => 'fa fa-reorder',
                        'url' => '#',
                        'items' => [
                            ['label' => 'RAC', 'icon' => 'fa fa-info-circle', 'url' => ['/inspectionscontrol/index']],
                            //['label' => 'MWO', 'icon' => 'fa fa-info-circle', 'url' => ['/nw8control/index']],
                        ],
                    ],
					
                    ['label' => 'RAC', 'icon' => 'fa fa-info-circle', 'url' => ['/inspectionscontrol/index']],
					[
                        'label' => 'Energy Test Monitoring',
                        'icon' => 'fa fa-reorder',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Register', 'icon' => 'fa fa-info-circle', 'url' => ['/calc-z-config/index']],
                            ['label' => 'Input', 'icon' => 'fa fa-info-circle', 'url' => ['/calc-z-testes/index']],
                            ['label' => 'Monitoring', 'icon' => 'fa fa-info-circle', 'url' => ['/calc-z-testes/zcalc']],
                        ],
                    ],
					// [
                        // 'label' => 'Teste',
                        // 'icon' => 'fa fa-reorder',
                        // 'url' => '#',
                        // 'items' => [
                            // ['label' => 'Register', 'icon' => 'fa fa-info-circle', 'url' => ['/teste2/index']]
                        // ],
                    // ],
					[
						'label' => 'XRF',
                        'icon' => 'fa fa-reorder',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Status RoHS', 'icon' => 'fa fa-info-circle', 'url' => ['/statusrohs/index']]
                        ],
					],
                    [ 'label' => 'Goals Plan', 'icon' => 'fa fa-search', 'url' => '#',],
                    ['label' => 'QHI Board', 'icon' => 'fa fa-check-square-o', 'url' => '#'],
                    ['label' => 'Field Installation', 'icon' => 'fa fa-check-square-o', 'url' => ['/appinstalacao/index']],
					//['label' => 'Load ON', 'icon' => 'fa fa-line-chart', 'url' => ['/site/loadon']],
					//['label' => 'Control of Inspector Load', 'icon' => 'fa fa-line-chart', 'url' => ['/site/index']],

                ],
            ]
        ) ?>
		


        <ul class="sidebar-menu">
            <li class="header"><span>Sistemas LG</span></li>
            <li>
                <a href="http://gerp.lge.com:6010/pbf/system/navigation/intro.dev?mode=START" TARGET="_blank">
                <i class="fa fa-globe"></i>  <span>GERP</span></a>
            </li>
            <li>
                <a href="http://az.gmes.lge.com/" TARGET="_blank">
                    <i class="fa fa-globe"></i>  <span>GMES</span></a>
            </li>
            <li>
                <a href="http://dqms.lge.com:5909/CoMain.jsp" TARGET="_blank">
                    <i class="fa fa-globe"></i>  <span>DQMS</span></a>
            </li>
            <li>
                <a href="http://cwgpdm.cw.lge.com/enovia/common/emxNavigator.jsp" TARGET="_blank">
                    <i class="fa fa-globe"></i>  <span>GPDM</span></a>
            </li>
            <li>
                <a href="http://gqms.lge.com:6105/comm/commonSSOLogin.jsp" TARGET="_blank">
                    <i class="fa fa-globe"></i>  <span>GQMS</span></a>
            </li>
        </ul>
    </section>

</aside>
