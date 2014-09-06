<?php

/**
 * This is the model class for table "program".
 *
 * The followings are the available columns in table 'program':
 * @property integer $ID
 * @property string $Name
 * @property string Thumbnailname
 * @property double $Downloads
 * @property string $Kategorie
 * @property double $Sterne
 * @property integer $enabled
 * @property integer $visible
 * @property string $Language
 * @property string $programming_lang
 * @property string $Description
 * @property string $add_date
 * @property string $download_url
 * @property string $sourceforge_url
 * @property string $homepage_url
 * @property string $github_url
 * @property integer $uses_absCanv
 * @property string $update_identifier
 * @property integer $highscore_gid
 *
 * @property ProgramUpdates $version
 */
class Program extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{programs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Thumbnailname, Downloads, Kategorie, Sterne, enabled, visible, Language, programming_lang, Description, add_date, uses_absCanv', 'required'),
			array('enabled, visible, uses_absCanv, highscore_gid', 'numerical', 'integerOnly'=>true),
			array('Downloads, Sterne', 'numerical'),
			array('update_identifier', 'length', 'max'=>64),
			array('programming_lang', 'length', 'max'=>16),
			// The following rule is used by search().
			array('ID, Name, Thumbnailname, Downloads, Kategorie, Sterne, enabled, visible, Language, programming_lang, Description, add_date, download_url, sourceforge_url, homepage_url, github_url, uses_absCanv, update_identifier, highscore_gid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'version' =>
				[
					self::HAS_ONE,
					'ProgramUpdates',
					[
						'Name' => 'update_identifier'
					]],
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
			'Thumbnailname' => 'Thumbnail name',
			'Downloads' => 'Downloads',
			'Kategorie' => 'Kategorie',
			'Sterne' => 'Sterne',
			'enabled' => 'Enabled',
			'visible' => 'Visible',
			'Language' => 'Language',
			'programming_lang' => 'programming Language',
			'Description' => 'Description',
			'add_date' => 'Add Date',
			'download_url' => 'Download Url',
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
		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Thumbnailname',$this->Thumbnailname,true);
		$criteria->compare('Downloads',$this->Downloads);
		$criteria->compare('Kategorie',$this->Kategorie,true);
		$criteria->compare('Sterne',$this->Sterne);
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('Language',$this->Language,true);
		$criteria->compare('programming_lang',$this->programming_lang,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('download_url',$this->download_url,true);
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
	 * @return Program the static model class
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
	 * @throws CHttpException
	 */
	public function getImagePath() {
		if (file_exists('images/programs/thumbnails/' . $this->Name . '.png'))
			return '/images/programs/thumbnails/' . rawurlencode($this->Name) . '.png';
//		else if (file_exists('images/programs/thumbnails/' . $this->Name . '.jpg'))
//			return '/images/programs/thumbnails/' . $this->Name . '.jpg';
		else throw new CHttpException(500, "Could not find Program Thumbnail '" . $this->Name . "'");
	}

	/**
	 * @return string
	 */
	public function getLink() {
		return '/programs/view/' . rawurlencode($this->Name);
	}

	/**
	 * @return string
	 */
	public function getAbsoluteLink() {
		return 'http://www.mikescher.de' . $this->getLink();
	}

	/**
	 * @return string
	 */
	public function getDownloadLink() {
		return '/programs/download/' . rawurlencode($this->Name);
	}

	/**
	 * @return string
	 */
	public function getDirectDownloadLink() {
		if ($this->download_url == 'direkt' || is_null($this->download_url) || empty($this->download_url))
			return '/data/programs/' . rawurlencode($this->Name) . '.zip';
		else
			return $this->download_url;
	}

	/**
	 * @return string[]
	 */
	public function getLanguageList() {
		return explode("|", $this->Language);
	}

	/**
	 * @return DateTime
	 */
	public function getDateTime() {
		return new DateTime($this->add_date);
	}

	/**
	 * @return string
	 */
	public function getStarHTML()
	{
		$out = '';

		for ($i = 0; $i < 4; $i++) {
			if ($i < $this->Sterne)
				$out .= MsHtml::icon(MsHtml::ICON_STAR);
			else
				$out .= MsHtml::icon(MsHtml::ICON_STAR_EMPTY);
		}

		return $out;
	}

	/**
	 * @return array()
	 */
	public function getDescriptions()
	{
		$result = array();

		$path = "data/programs/desc/" . $this->Name . "/*";

		$tl_paths = glob($path, GLOB_MARK);

		foreach ($tl_paths as $fn)
		{
			if (MsHelper::endsWith($fn, DIRECTORY_SEPARATOR))
			{
				$bl_paths = glob($fn . '*.markdown');

				$bl_arr = array();
				foreach ($bl_paths as $bl_fn)
				{
					$bl_arr[] = ['type' => 1, 'name' => ProgramHelper::getIndexedFilename($bl_fn, $num), 'path' => $bl_fn];
				}

				$result[] = ['type' => 0,'name' => ProgramHelper::getIndexedFilename($fn, $num), 'items' => $bl_arr];
			}
			else if (MsHelper::endsWith($fn, ".markdown"))
			{
				$ifn = ProgramHelper::getIndexedFilename($fn, $num);

				if (strcasecmp($ifn, "index") == 0) // == 0 : true
				{
					array_unshift($result, ['type' => 1,'name' => $ifn, 'path' => $fn]);
				}
				else
				{
					$result[] = ['type' => 1,'name' => $ifn, 'path' => $fn];
				}
			}
		}

		return $result;
	}

	public function deleteDescriptions()
	{
		MsHelper::deleteDir("data/programs/desc/" . $this->Name . "/");
	}

	/**
	 * @return HighscoreGames
	 */
	public function getHighscoreGame()
	{
		return HighscoreGames::model()->findByPk($this->highscore_gid);
	}

	/**
	 * @param $search string[]
	 * @return array()
	 */
	public static function getSearchResults($search)
	{
		/* @var $all Program[] */
		/* @var $resultarr Program[] */
		$all = Program::model()->findAll();

		$resultarr = array();

		foreach($search as $searchpart)
		{
			foreach($all as $prog)
			{
				if (! $prog->enabled || ! $prog->visible)
					continue;

				if (stripos($prog->Name, $searchpart) !== false && ! in_array($prog, $resultarr))
					$resultarr []= $prog;

				if (stripos($prog->Description, $searchpart) !== false && ! in_array($prog, $resultarr))
					$resultarr []= $prog;
			}
		}

		$result = array();

		foreach($resultarr as $prog)
		{
			$result []=
				[
					'Name' => $prog->Name,
					'Description' => $prog->Description,
					'Link' => $prog->GetLink(),
					'Image' => $prog->GetImagePath(),
				];
		}

		return $result;
	}
}
