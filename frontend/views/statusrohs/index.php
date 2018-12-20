<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\statusrohsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'StatusRoHS';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
	google.charts.load('current', {'packages':['bar', 'corechart', 'table']});

  $(document).ready(function(){
      	
      

        $.ajax({
            url: '?r=statusrohs/getanos',
            type: 'get',
            success: function (data) {
            	$('#container').html(data);
            	var ano = $('select').val();
            	var path = '?r=statusrohs/getmonthschart&ano=';
		        var path = path.concat(ano);
		        $.ajax({
		            url: path,
		            type: 'get',
		            success: function (data) {
		            	var lista = JSON.parse(data);

		            	drawChart(lista);
		            },
		            error: function(xhr, ajaxOptions, thrownError){
		            	alert(thrownError);
		            }
		        }); 
            },
            error: function(xhr, ajaxOptions, thrownError){
            	alert(thrownError);
            }
        }); 



  });


  $(document).on('change','select',function(){
  		var path = '?r=statusrohs/getmonths&ano=';
        var path = path.concat($('select').val());
        $.ajax({
            url: path,
            type: 'get',
            success: function (data) {
            	$('#cards').html(data);
            },
            error: function(xhr, ajaxOptions, thrownError){
            	alert(thrownError);
            }
          }); 
        /*var path = '?r=statusrohs/getmonthschart&ano=';
        var path = path.concat($('select').val());
        $.ajax({
            url: path,
            type: 'get',
            success: function (data) {
            	var lista = JSON.parse(data);
            	
            	drawChart(lista);
            },
            error: function(xhr, ajaxOptions, thrownError){
            	alert(thrownError);
            }
        }); */
   });


  

      function drawChart(lista) {
      	var valores = [['Month', 'Plan', 'Result']];
	    for(i = 0; i < lista.length; i++){
	        valores.push([lista[i]['month'],parseFloat(lista[i]['plan']),parseFloat(lista[i]['result'])]);
	    }
        var data = google.visualization.arrayToDataTable(valores);
        

        var options = {
          chart: {
            title: 'XRF Performance',
            subtitle: 'Plan and Result',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('grafico'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
$this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>


	<div class="statusrohs-index">
		<div class="box box-danger container">
	        <div class="box-header with-border">

				<h1><?= Html::encode($this->title) ?></h1>
			</div>
		
			
			<div id="container"></div>
			
		</div>
	</div>

