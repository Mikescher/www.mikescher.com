<?php
/**
* Widget for insert Disqus code in to page.
*
* @author Anton Kucherov <idexter.ru@gmail.com>
* @link http://idexter.ru/
* @copyright 2013 idexter.ru
*/

/**
 * YiiDisqusWidget
 * @author Anton Kucherov <idexter.ru@gmail.com>
 */
class YiiDisqusWidget extends CWidget
{
    /**
     * @var string disqus_shortname
     */
    public $shortname;
    /**
     * @var string disqus_identifier
     */
    public $identifier;
    /**
     * @var string disqus_title
     */
    public $title;
    /**
     * @var string disqus_url
     */
    public $url;
    /**
     * @var string disqus_category_id
     */
    public $category_id;

    /**
     * @throws CHttpException
     */
    public function init()
    {
        parent::init();
        if (empty($this->shortname)) {
            throw new CHttpException(500, Yii::t('YiiDisqusWidget', 'Parameter "disqus_shortname" is not set'));
        }

        $params = array();
        $params['shortname'] = $this->shortname;
        $params['identifier'] = $this->identifier;
        $params['title'] = $this->title;
        $params['url'] = $this->url;
        $params['category_id'] = $this->category_id;

        $this->render('yiidisqus',$params);
    }
}