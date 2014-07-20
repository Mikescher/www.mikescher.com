<?php

/**
 * This is the model class for table "{{highscoreentries}}".
 *
 * The followings are the available columns in table '{{highscoreentries}}':
 * @property integer $GAME_ID
 * @property string $POINTS
 * @property string $PLAYER
 * @property integer $PLAYERID
 * @property string $CHECKSUM
 * @property string $TIMESTAMP
 * @property string $IP
 * @property HighscoreGames $GAME
 */
class HighscoreEntries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{highscoreentries}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GAME_ID, PLAYER, CHECKSUM, TIMESTAMP, IP', 'required'),
			array('GAME_ID, PLAYERID', 'numerical', 'integerOnly'=>true),
			array('POINTS', 'length', 'max'=>20),
			array('PLAYER, IP', 'length', 'max'=>41),
			array('CHECKSUM', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('GAME_ID, POINTS, PLAYER, PLAYERID, CHECKSUM, TIMESTAMP, IP', 'safe', 'on'=>'search'),
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
			'GAME' =>
				[
					self::HAS_ONE,
					'HighscoreGames',
					[
						'ID' => 'GAME_ID'
					]
				],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'GAME_ID' => 'Game',
			'POINTS' => 'Points',
			'PLAYER' => 'Player',
			'PLAYERID' => 'Playerid',
			'CHECKSUM' => 'Checksum',
			'TIMESTAMP' => 'Timestamp',
			'IP' => 'IP',
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

		$criteria->compare('GAME_ID',$this->GAME_ID);
		$criteria->compare('POINTS',$this->POINTS,true);
		$criteria->compare('PLAYER',$this->PLAYER,true);
		$criteria->compare('PLAYERID',$this->PLAYERID);
		$criteria->compare('CHECKSUM',$this->CHECKSUM,true);
		$criteria->compare('TIMESTAMP',$this->TIMESTAMP,true);
		$criteria->compare('IP',$this->IP,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HighscoreEntries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//####################################
	//########### MY FUNCTIONS ###########
	//####################################

	/**
	 * @param $rand
	 * @return string
	 */
	public function generateChecksum($rand)
	{
		$game = HighscoreGames::model()->findByPk($this->GAME_ID);
		/* @var $game HighscoreGames */

		if ($this->PLAYERID >= 0)
			return md5($rand . $this->PLAYER . $this->PLAYERID . $this->POINTS . $game->ID);
		else
			return md5($rand . $this->PLAYER . $this->POINTS . $game->ID);
	}

	/**
	 * @param $rand
	 * @return bool
	 */
	public function checkChecksum($rand)
	{
		return $this->generateChecksum($rand) == $this->CHECKSUM;
	}
}
