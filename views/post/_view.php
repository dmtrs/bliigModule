<div class="post">
	<div class="title">
        <?php $this->beginWidget('EReplacer', array(
            'bag'=>'{}',
            'data'=>Yii::app()->params['icons'],
            'replace'=>'(isset($data[$el])) ? "<img src=\''.Yii::app()->request->baseUrl.'/".$data[$el]."\' />" : null;'
        ));?>
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
        <?php $this->endWidget(); ?>

        <?php if(!Yii::app()->user->isGuest) {
            echo CHtml::link(
                CHtml::image(Yii::app()->request->baseUrl."/data/16/page_edit.png", 
                    'Edit',
                    array('style'=>'float: right;',)
                ), $this->createUrl('update', array('id'=>$data->id))); 
        } ?>

	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
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
    $this->widget('fancybox.EFancyBox', array(
        'target'=>'.fancybox',
        'config'=>array(),
        )
    );
    Yii::app()->clientScript->registerCss('fancybox-imgs', 
    '
    a .fancybox
    {
        border: 0;
    }
    .thumb 
    {
        border: 0.5px solid;
        float: left;
        margin: 0em 0.5em;
        padding: 0.3em 0.3em 0.6em;
    }
    .fsmall
    { 
        height: 32px; 
        float: left;
    }
    .fnormal
    {
        height: 64px;
        float: left;
    }
    .fbig
    {
        height: 128px;
        float: left;
    }');
}
