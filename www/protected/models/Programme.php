<?php

/**
 * This is the model class for table "programme".
 *
 * The followings are the available columns in table 'programme':
 * @property integer $ID
 * @property string $Name
 * @property double $Downloads
 * @property string $Kategorie
 * @property double $Sterne
 * @property integer $enabled
 * @property integer $visible
 * @property string $Language
 * @property string $Description
 * @property string $add_date
 * @property string $download_url
 * @property integer $viewable_code
 * @property string $sourceforge_url
 * @property string $homepage_url
 * @property string $github_url
 * @property integer $uses_absCanv
 * @property string $update_identifier
 * @property integer $highscore_gid
 */
class Programme extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'programme';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Downloads, Kategorie, Sterne, enabled, visible, Language, Description, add_date, download_url, viewable_code, sourceforge_url, homepage_url, github_url, uses_absCanv, update_identifier', 'required'),
			array('enabled, visible, viewable_code, uses_absCanv, highscore_gid', 'numerical', 'integerOnly'=>true),
			array('Downloads, Sterne', 'numerical'),
			array('update_identifier', 'length', 'max'=>28),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, Name, Downloads, Kategorie, Sterne, enabled, visible, Language, Description, add_date, download_url, viewable_code, sourceforge_url, homepage_url, github_url, uses_absCanv, update_identifier, highscore_gid', 'safe', 'on'=>'search'),
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
			'Name' => 'Name',
			'Downloads' => 'Downloads',
			'Kategorie' => 'Kategorie',
			'Sterne' => 'Sterne',
			'enabled' => 'Enabled',
			'visible' => 'Visible',
			'Language' => 'Language',
			'Description' => 'Description',
			'add_date' => 'Add Date',
			'download_url' => 'Download Url',
			'viewable_code' => 'Viewable Code',
			'sourceforge_url' => 'Sourceforge Url',
			'homepage_url' => 'Homepage Url',
			'github_url' => 'Github Url',
			'uses_absCanv' => 'Uses Abs Canv',
			'update_identifier' => 'Update Identifier',
			'highscore_gid' => 'Highscore Gid',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Downloads',$this->Downloads);
		$criteria->compare('Kategorie',$this->Kategorie,true);
		$criteria->compare('Sterne',$this->Sterne);
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('Language',$this->Language,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('download_url',$this->download_url,true);
		$criteria->compare('viewable_code',$this->viewable_code);
		$criteria->compare('sourceforge_url',$this->sourceforge_url,true);
		$criteria->compare('homepage_url',$this->homepage_url,true);
		$criteria->compare('github_url',$this->github_url,true);
		$criteria->compare('uses_absCanv',$this->uses_absCanv);
		$criteria->compare('update_identifier',$this->update_identifier,true);
		$criteria->compare('highscore_gid',$this->highscore_gid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'Pagination' => array (
				'PageSize' => 50 //edit your number items per page here
              ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Programme the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
