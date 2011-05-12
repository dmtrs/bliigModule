<div class="post">
	<div class="title">
        <?php $this->beginWidget('ext.EReplacer', array(
            'bag'=>'{}',
            'data'=>Yii::app()->params['icons'],
            'replace'=>'(isset($data[$el])) ? "<img src=\''.Yii::app()->request->baseUrl.'/".$data[$el]."\' />" : null;'
        ));?>
		<?php echo CHtml::encode($data->title); ?>
        <?php $this->endWidget(); ?>
	</div>
	<div class="author">
		posted by UPDATE USER DETAILS<?php echo date('F j, Y'); ?>
	</div>
	<div class="content">
		<?php
            if(!$data->htmlflag)
			    $this->beginWidget('CMarkdown', array('purifyOutput'=>true));

			echo $data->content;

            if(!$data->htmlflag)
			    $this->endWidget();
		?>
	</div>
	<div class="nav">
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo CHtml::link('Permalink', $data->url); ?> |
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>
</div>
<?php
if($data->imgs) {
    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'.fancybox',
        'config'=>array(),
        )
    );
    Yii::app()->clientScript->registerCss('fancybox-imgs', 
    '
    .fsmall
    { 
        height: 32px; 
    }
    .fnormal
    {
        height: 64px;
    }
    .fbig
    {
        height: 128px;
    }');
}
