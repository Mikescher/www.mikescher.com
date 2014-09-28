<?php

/**
 * This is the model class for table "{{eulerproblem}}".
 *
 * The followings are the available columns in table '{{eulerproblem}}':
 * @property integer $Problemnumber
 * @property string $Problemtitle
 * @property string $Problemdescription
 * @property string $Code
 * @property string $Explanation
 * @property integer $AbbreviatedCode
 * @property string $SolutionSteps
 * @property string $SolutionTime
 * @property string $SolutionWidth
 * @property string $SolutionHeight
 * @property string $SolutionValue
 */
class EulerProblem extends CActiveRecord
{
	const TIMELEVEL_PERFECT = 0;
	const TIMELEVEL_GOOD    = 1;
	const TIMELEVEL_OK      = 2;
	const TIMELEVEL_BAD     = 3;
	const TIMELEVEL_FAIL    = 4;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{eulerproblem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Problemnumber, Problemtitle, Problemdescription, Code, Explanation, AbbreviatedCode, SolutionSteps, SolutionTime, SolutionWidth, SolutionHeight, SolutionValue', 'required'),
			array('AbbreviatedCode', 'numerical', 'integerOnly'=>true),
			array('SolutionSteps, SolutionTime, SolutionValue', 'length', 'max'=>20),
			array('Problemtitle', 'length', 'max'=>50),

			array('Problemnumber, Problemtitle, Problemdescription, Code, Explanation, AbbreviatedCode, SolutionSteps, SolutionTime, SolutionValue', 'safe', 'on'=>'search'),
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
			'Problemnumber' => 'Problemnumber',
			'Problemtitle' => 'Problemtitle',
			'Problemdescription' => 'Problemdescription',
			'Code' => 'Code',
			'Explanation' => 'Explanation',
			'AbbreviatedCode' => 'Abbreviated Code',
			'SolutionSteps' => 'Solution Steps',
			'SolutionTime' => 'Solution Time',
			'SolutionWidth' => 'Solution Width',
			'SolutionHeight' => 'Solution Height',
			'SolutionValue' => 'Solution Value',
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

		$criteria->compare('Problemnumber',$this->Problemnumber);
		$criteria->compare('Problemtitle',$this->Problemdescription,true);
		$criteria->compare('Problemdescription',$this->Problemdescription,true);
		$criteria->compare('Code',$this->Code,true);
		$criteria->compare('Explanation',$this->Explanation,true);
		$criteria->compare('AbbreviatedCode',$this->AbbreviatedCode);
		$criteria->compare('SolutionSteps',$this->SolutionSteps,true);
		$criteria->compare('SolutionTime',$this->SolutionTime,true);
		$criteria->compare('SolutionWidth',$this->SolutionWidth);
		$criteria->compare('SolutionHeight',$this->SolutionHeight);
		$criteria->compare('SolutionValue',$this->SolutionValue,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EulerProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getSourcecodefile($absolute = true)
	{
		return ($absolute ? '/' : '') . 'data/blog/Befunge/Euler_Problem-' . str_pad($this->Problemnumber, 3, '0', STR_PAD_LEFT) . '.b93';
	}

	public function getTimeScore()
	{
		if ($this->SolutionTime < 100) // < 100ms
			return EulerProblem::TIMELEVEL_PERFECT;

		else if ($this->SolutionTime < 15 * 1000) // < 5s
			return EulerProblem::TIMELEVEL_GOOD;

		else if ($this->SolutionTime < 60 * 1000) // < 1min
			return EulerProblem::TIMELEVEL_OK;

		else if ($this->SolutionTime < 5 * 60 * 1000) // < 5min
			return EulerProblem::TIMELEVEL_BAD;

		else
			return EulerProblem::TIMELEVEL_FAIL;
	}

	public function isBefunge93()
	{
		return $this->SolutionWidth <= 80 AND $this->SolutionHeight <= 25;
	}

	public function generateMarkdown()
	{
		$num_padded = str_pad($this->Problemnumber, 3, '0', STR_PAD_LEFT);

		return
			'Problem [' . $num_padded. '](http://projecteuler.net/problem=' . $num_padded . '): ' . $this->Problemtitle . PHP_EOL .
			'--------' . PHP_EOL .
			'' . PHP_EOL .
			MsHelper::encloseLines($this->Problemdescription, '> ', '') . PHP_EOL .
			'' . PHP_EOL .
			'```befunge' . PHP_EOL .
			$this->Code . PHP_EOL .
			'```' . PHP_EOL .
			'[Download](/data/blog/Befunge/Euler_Problem-' . $num_padded . '.b93)' . PHP_EOL .
			'' . PHP_EOL .
			$this->Explanation . PHP_EOL .
			'' . PHP_EOL .
			'**Interpreter steps:** `' . number_format($this->SolutionSteps, 0, null, ',') . '`  ' . PHP_EOL .
			'**Execution time** ([BefunExec](/programs/view/BefunGen)): `' . number_format($this->SolutionTime, 0, null, ',') . '` ms' . (($this->SolutionTime < 1000) ? ('  ') : (' *(= ' . MsHelper::formatMilliseconds($this->SolutionTime) . ')*  ')) . PHP_EOL .
			'**Program size:** `' . $this->SolutionWidth . 'x' . $this->SolutionHeight . '`  ' . PHP_EOL .
			'**Solution:** `' . number_format($this->SolutionValue, 0, null, ',') . '`  ';
	}
}
