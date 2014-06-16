<?php

/**
 * This is the model class for table "{{updates}}".
 *
 * The followings are the available columns in table '{{updates}}':
 * @property string $Name
 * @property string $Version
 * @property string $Link
 *
 * @property ProgramUpdatesLog[] $log
 */
class ProgramUpdates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{updates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Version, Link', 'required'),
			array('Name', 'length', 'max'=>64),
			// The following rule is used by search().
			array('Name, Version, Link', 'safe', 'on'=>'search'),
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
			'log' =>
			[
				self::HAS_MANY,
				'ProgramUpdatesLog',
				[
					'programname' => 'Name'
				]],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Name' => 'Name',
			'Version' => 'Version',
			'Link' => 'Link',
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

		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Version',$this->Version,true);
		$criteria->compare('Link',$this->Link,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProgramUpdates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
