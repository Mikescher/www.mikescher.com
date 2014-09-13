<?php

/**
 * This is the model class for table "{{blog}}".
 *
 * The followings are the available columns in table '{{blog}}':
 * @property integer $ID
 * @property string $Date
 * @property string $Title
 * @property string $Content
 * @property string $Visible
 * @property string $Enabled
 */
class BlogPost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{blog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Date, Title, Content, Visible, Enabled', 'required'),
			array('Visible, Enabled', 'numerical', 'integerOnly'=>true),

			array('ID, Date, Title, Content, Visible, Enabled', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'Date' => 'Date',
			'Title' => 'Title',
			'Content' => 'Content',
			'Visible' => 'Visible',
			'Enabled' => 'Enabled',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('Date',$this->Date,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('Visible',$this->Visible,true);
		$criteria->compare('Enabled',$this->Enabled,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlogPost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//####################################
	//########### MY FUNCTIONS ###########
	//####################################

	/**
	 * @return DateTime
	 */
	public function getDateTime() {
		return new DateTime($this->Date);
	}

	/**
	 * @return string
	 */
	public function getLink() {
		$name = $this->Title;

		$name = str_replace(' ', '_', $name);
		$name = preg_replace("/[^A-Za-z0-9_]/", '', $name);

		return '/blog/' . $this->ID . '/' . rawurlencode($name);
	}

	/**
	 * @return string
	 */
	public function getAbsoluteLink() {
		return 'http://www.mikescher.de' . $this->getLink();
	}

	/**
	 * @param $search string[]
	 * @return array()
	 */
	public static function getSearchResults($search)
	{
		/* @var $all BlogPost[] */
		/* @var $resultarr BlogPost[] */
		$all = BlogPost::model()->findAll();

		$resultarr = array();

		foreach($search as $searchpart)
		{
			foreach($all as $post)
			{
				if (stripos($post->Title, $searchpart) !== false && ! in_array($post, $resultarr))
					$resultarr []= $post;
			}
		}

		$result = array();

		foreach($resultarr as $post)
		{
			$result []=
				[
					'Name' => $post->Title,
					'Description' => null,
					'Link' => $post->GetLink(),
					'Image' => '/images/search/sresult_blog.png',
				];
		}

		return $result;
	}
}
