<?php
/**
 * EReadMore
 * ---------
 * A simple extension to shorten an html code.
 *
 * ###Requirements
 * - [DOMDocument](http://www.php.net/manual/en/intro.dom.php)
 *
 * ###Description
 * This a common functionality found in blogs, where you see a part
 * of an article and there is link usually named read more where
 * get redirected to the full article.
 *
 * ###Use
 * ####Simple case
 * In the view add:
 * ~~~
 * [php]
 *     <?php $this->beginWidget('application.extensions.EReadMore.EReadMore', array(
 *          'linkUrl'=>$data->url
 *      ));?>
 *      <div>
 *          <h1>EReadMore</h1>
 *        	<p>A simple extension to shorten an html code.</p>
 *        	<h2>Requirements</h2>
 *           <ul>
 *               <li><a href='http://www.php.net/manual/en/intro.dom.php' >DOMDocument</a></li>
 *           </ul>
 *      </div>
 *      <?php $this->endWidget(); ?>
 * ~~~
 * ####Advanced use
 * Check the EReadMore code options to see what you can set.
 *
 * ###Resources
 * - [Github repo](http://www.github.com/dmtrs/EReadMore)
 * - [Extension site](http://www.yiiframework.com/extension/ereadmore/)
 *
 * @version 1.0
 * @author Dimitrios Mengidis <tydeas.dr@gmail.com>
 */

class EReadMore extends CWidget
{
    /** 
     * @var boolean show the 'Read more...' like link.
     */
    public $showLink = true;
    /** 
     * @var array link html options.
     * @since 1.0
     */
    public $linkHtmlOptions = array(); 
    /** 
     * @var string link label, default 'Read more...'.
     * @since 1.0
     */
    public $linkText = 'Read more...'; 
    /** 
     * @var string link url.
     * @since 1.0
     */
    public $linkUrl; 
    /** 
     * @var string the short version html.    
     * @since 1.0
     */
    public $short = ''; 
    /**
     * @var string tag name of the short verion root.
     * @since 1.0
     */
    public $root = 'div'; 
    /**
     * @var array html options of the short version root element.
     * @since 1.0
     */
    public $rootHtmlOptions = array('classs'=>'ereadmore-short'); 
    /**
     * @var string nodename of the last html element rendered.
     * @since 1.0
     */
    public $nodeName = 'p';
    /**
     * @var boolean if short version will be returned or echoed.
     * @since 1.0
     */
    public $return = false; 
    /**
     * @var DOMDocument domdocument used to split the html.
     * @since 1.0
     */
    private $doc;
    public function init()
    {    
        ob_start();
        $this->doc = new DOMDocument();          
        parent::init();
    }
    public function run()
    {
        $html = ob_get_clean();
        $this->doc->loadHTML($html);
        $this->shortHtml();
        if($this->return)
            return $this->short;
        else
            echo $this->short;
    }
    private function shortHtml()
    {

        foreach($this->doc->getElementsByTagName('body') as $body)
        {
            $shortdom = new DOMDocument();
            $root = CHtml::tag($this->root, $this->rootHtmlOptions);
            $shortdom->loadHTML($root);
            
            foreach($body->childNodes as $node)
            {
               $newnode = $shortdom->importNode($node, true);
               $shortdom->documentElement->appendChild($newnode);
               if($node->nodeName == $this->nodeName)
                   break;
            }

            $this->short = $shortdom->saveHTML();
            if($this->showLink)
                    $this->short .= CHtml::link($this->linkText, $this->linkUrl, $this->linkHtmlOptions);
        }
    }
}
