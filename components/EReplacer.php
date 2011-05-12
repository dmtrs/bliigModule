<?php
/** 
 * EReplacer
 * =========
 * Yii framework extension to replace context of text.
 * 
 * ###Description and use cases
 *  You can use this extension to replaces 'standar' parts for a string 
 * to whatever you like. I will describe my personal use case.
 *  In my blog I used to add posts with title like:
 *
 * - {yii}{ext} EReadmore
 * - {yii}{wiki} A simple... 
 * - {php} New to ...
 * 
 *  This was to categorize the Posts. So one day i wanted to replace all this 
 *
 * with some images. The code below does this work for me.
 *  Other use cases can be to display emoticons in text and etc.
 * 
 * ###Code example
 *  Notice that there is not constrain to use a key=>value array as data.
 *  What $data will be depends entirely to you and its related to who you 
 * will access that data in the <code>replace</code> eval phrase. 
 * 
 * ~~~
 * [php]
 * $this->beginWidget('ext.EReplacer', array(
 *    'bag'=>'{}',
 *     'data'=>array(
 *         'yii'=>'http://image src...',
 *         'wiki'=>'http:///image src...',
 *         'php'=>'http://image src...',
 *      ),
 *    'replace'=>'"<img src=\'".$data[$el]."\' />";',
 * ));
 * echo $post->title;
 * $this->endWidget();
 * ~~~
 *  
 * ###Thanks
 * I would like to thank rawtaz, SJFriedl, ciss & robert___ for the regexp help.
 *
 * @author Dimitrios Mengidis
 * @version 0.1
 */
class EReplacer extends CWidget
{
    /** The text to be parsed.
     *  If this attribute is not set the extension will 
     * parse the text echoed between the begin/endWidget calls of it.
     *
     * @var string
     * @since 0.1
     */
    public $text;
    /** The character used to open and close an element.
     *  Example: If we have {foo}{bar}{monkey} then $bag='{}'
     * This variable will be used in regular expression for methods
     * <code>preg_match_all</code> and <code>preg_replace</code>.So if 
     * you want to use regexp special chars be sure you escape them.
     *  If length is odd or if this attribute is not set at all a 
     * CException will be raised.
     * 
     * @var string
     * @since 0.1
     */
    public $bag; 
    /** Data for that you are passed to the widget and can be used in
     * the eval expression, by using <code>$data</code>. 
     * 
     * @var mixed
     * @since 0.1
     */
    public $data; 
    /** The expression that will be evaluated and then replace each match.
     *  If this eval returns <code>NULL</code> no replacement will occure, 
     * if it returns <code>false</code> an <code>CException</code> will be raised.
     *  You can access data passed with <code>$data</code>, content of bag can be accessed with $el.
     * 
     * @var string
     * @since 0.1
     */
    public $replace; 
    /** All properties that are required to be set.
     * 
     * @var array
     * @since 0.1
     */
    private $issetProperties = array( 'bag', 'replace' );
    /** The characters that are the start of the bag.
     * 
     * @var string
     * @since 0.1
     */
    private $_st;
    /** The characters that are the end of the bag.
     * 
     * @var string
     * @since 0.1
     */
    private $_en;
    /** 
     *  Check if all properties that are required are set.
     * Splits the bag to start and end.
     *  If <code>test</code> is not set it calls <code>ob_start()</code>.
     * 
     * @since 0.1
     */
    public function init()
    {
        $this->checkProperties();

        $sp = strlen($this->bag)/2;
        $bagSplit = str_split($this->bag, $sp);

        $this->_st = $bagSplit[0];
        $this->_en = $bagSplit[1];

        unset($sp);
        unset($bagSplit);
        
        if(!isset($this->text)) {
            ob_start();
        }
        parent::init();
    }
    /** 
     *  If <code>ob_start()</code> was called in <code>init()</code> then 
     * <code>ob_get_cleant()</code> is executed and <code>$this->text</code> takes 
     * the value of the capture.
     *  It get's all the string that are in a bag in from the text and it replaces 
     * with the return of <code>eval($this->replace)</code>.
     *
     * @since 0.1
     */
    public function run()
    {
        if(!isset($this->text)) {
            $this->text = ob_get_clean();
        }
        $data = $this->data;
        if ( preg_match_all( '/'.$this->_st.' ( [^'.$this->_en.']+ ) '.$this->_en.'/x', $this->text, $matches ) > 0 )
        {
            if(strpos($this->replace, 'return') !== 0 ) {
                $this->replace .= 'return '.$this->replace;
            }
            $found = $matches[1];
            foreach (array_unique($found) as $el)
            {               
                $r = eval($this->replace);
                if($r === false)
                    throw new CException("Eval of replace raised an error.");
                if(isset($r) && $r !== false ) {
                    $this->text = preg_replace('/'.$this->_st.$el.$this->_en.'/', $r, $this->text);       
                }
                $r = null;
            }           
        }
        echo $this->text;

    }
    /**
     * Check if all the required properties are set.
     * @since 0.1
     */ 
    private function checkProperties()
    {
        foreach($this->issetProperties as $p)
        {
            if(!isset($this->$p)) 
                throw new CException($p." property must be set.");
        }
        if((strlen($this->bag)%2) > 0 ) 
            throw new CException("Number of characters in bag string must be even.");
    }
}
