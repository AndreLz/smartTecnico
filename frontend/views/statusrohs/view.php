<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\statusrohs */

$this->title = $model->month;
$this->params['breadcrumbs'][] = ['label' => 'StatusRoHS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  $(document).ready(function(){

         $('.example-popover').popover({
		    container: 'body'
		  })

		  /*$('.botao-item').each(function () {
			    $(this).on("click", function () {
			        alert($(this).data('id'));
			    });
		   });*/

		  /*$.ajax({
            url: '?r=Item/getByStatus',
            type: 'post',
            datatype: 'json',
            contentType: "application/json; charset=utf-8",
            data:JSON.stringify({id:$('p').data('id')}),
            success: function (data) {
            	//alert(data);
            },
            error: function(xhr, ajaxOptions, thrownError){
            	//alert(thrownError);
            }
          });*/

  });

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>
</br>
<div class="statusrohs-view">

    <div class="box box-danger container">
        <div class="box-header with-border">
		<br>
			<h1><?= Html::encode($this->title) ?></h1>
		</div>

		<p id = "view-staturohs">
			<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
			<!--<?= Html::a('Delete', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this item?',
					'method' => 'post',
				],
			]) ?>
			-->

		</p>



		<?php if($model->status == 'NG'){
				echo DetailView::widget([
				'model' => $model,
				'attributes' => [
				    [
						'attribute' => 'status',
						'contentOptions' => ['style' => 'color:' . 
							($model->status == 'PENDING'?'#e6b800': ($model->status == 'APPROVED'?'green':'red'))],
					],
					'reason'
				],
			  ]);
			}
			else{
				echo DetailView::widget([
				'model' => $model,
				'attributes' => [
				    [
						'attribute' => 'status',
						'contentOptions' => ['style' => 'color:' . 
							($model->status == 'PENDING'?'#e6b800': ($model->status == 'APPROVED'?'green':'red'))],
					],
				],
			  ]);
			}
			 ?>
			

		<div class="table-responsive">
	        <input type="button" id="gerar_dias" value="Click" style="display: none;"> 
	        <br>
	        <table id="days-header" class="table  table-striped table-hover "><thead style="background-color:#b71c1c;color:#fff">

	            <?php echo $teste?>
	        </table>
	    </div>

		
	</div>

</div>

<?php
$script = <<< JS

  $(document).ready(function() {
 
         
  		  
          $('#view-staturohs').click(function(){
          		//alert("h"+$(this).data('id'));
          });
          
          
          
  });

  


JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

