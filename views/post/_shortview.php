<div class="post">
	<div class="title">
        <?php $this->beginWidget('ext.EReplacer', array(
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
                    array('style'=>'float: right;padding: 0.2em;',)
                ), $this->createUrl('update', array('id'=>$data->id))); 
        } ?>
	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
	</div>
	<div class="content">
		<?php
            $this->beginWidget('application.extensions.EReadMore.EReadMore', array(
                'linkUrl'=>$data->url
            ));
            if(!$data->htmlflag)
			    $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
            if(!$data->htmlflag)
                $this->endWidget();
			$this->endWidget();
		?>
	</div>
    <br/>
	<div class="nav">
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo CHtml::link('Permalink', $data->url); ?> |
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>
</div>
