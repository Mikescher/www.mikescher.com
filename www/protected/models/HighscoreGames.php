<?php

/**
 * This is the model class for table "{{highscoregames}}".
 *
 * The followings are the available columns in table '{{highscoregames}}':
 * @property integer $ID
 * @property string $NAME
 * @property string $SALT
 * @property HighscoreEntries[] $ENTRIES
 */
class HighscoreGames extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{highscoregames}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NAME, SALT', 'required'),
			array('NAME', 'length', 'max'=>63),
			array('SALT', 'length', 'max'=>6),
			// The following rule is used by search().
			array('ID, NAME', 'safe', 'on'=>'search'),
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
			'ENTRIES' =>
				[
					self::HAS_MANY,
					'HighscoreEntries',
					[
						'GAME_ID' => 'ID'
					],
					'order'=>'POINTS DESC'
				],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'NAME' => 'Name',
			'SALT' => 'Salt',
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
		$criteria->compare('NAME',$this->NAME,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HighscoreGames the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//####################################
	//########### MY FUNCTIONS ###########
	//####################################

	/**
	 * @return string
	 */
	public function getListLink()
	{
		return '/Highscores/list?gameid=' . $this->ID;
	}
}
