<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo CHtml::activeTextArea($model,'content',array('rows'=>10, 'cols'=>70)); ?>
		<p class="hint">You may use <a target="_blank" href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a>.</p>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model'=>$model,
			'attribute'=>'tags',
			'url'=>array('suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>50),
		)); ?>
		<p class="hint">Please separate different tags with commas.</p>
		<?php echo $form->error($model,'tags'); ?>
	</div>

    <div class="row" >
        <label>Other options <span onclick='$("#options-help").toggle();'>(?)</span></label>
        <?php echo $form->checkBox($model, 'htmlflag'); ?> Html code
        <?php echo $form->checkBox($model, 'imgs'); ?> Images
        <div class="row" id="options-help" style='display: none;' >
            <p><b>Fancybox</b> is enabled for elements with class <code>.fancybox</code></p>
            <p><b>Img Classes</b>
            <ul>
            	<li>fsmall, 32px height.</li>
            	<li>fnormal, 64px height.</li>
            	<li>fbig, 128px height</li>
            </ul></p>
        </div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php echo CHtml::ajaxSubmitButton('Preview', $this->createUrl('post/preview'), array(
            'success'=>'function(data) {
                    $("#preview").html(data).dialog("open");
            }')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->widget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'preview',
    'options'=>array(
        'title'=>'Preview',
        'autoOpen'=>false,
        'width'=>'80%',
        'height'=>'600',
        'modal'=>true,
        //'position'=>'top',
    ),
));?>