<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.07.14
 * Time: 18:41
 */

class CHitCounter extends CApplicationComponent {

	/* @var string $table_stats */
	public $table_stats;
	/* @var string $table_today */
	public $table_today;

	/* @var bool $updated */
	private $updated = false;
	/**
	 * Call this function on every view - it increments the hit counter if this is a new unique view
	 *
	 * @return bool true if this is a unique view
	 */
	public function increment()
	{
		if ($this->isBot()) // Do not track bots
			return;

		$this->tryUpdateStats();

		$connection=Yii::app()->db;

		$date_fmt = (new DateTime())->format('Y-m-d');
		$ipaddr = $_SERVER['REMOTE_ADDR'];

		$unique = $connection->createCommand("SELECT COUNT(*) FROM $this->table_today WHERE ipaddress = '$ipaddr'")->queryScalar() == 0;

		if ($unique)
		{
			$connection->createCommand("INSERT INTO $this->table_today (date, ipaddress) VALUES ('$date_fmt', '$ipaddr');")->execute();
		}

		return $unique;
	}

	public function getTotalCount()
	{
		$count = Yii::app()->db->createCommand("SELECT SUM(count) FROM $this->table_stats")->queryScalar();

		$count = (($count) ? $count : 0) + $this->getTodayCount();

		return $count;
	}

	public function getTodayCount()
	{
		$this->tryUpdateStats();

		return Yii::app()->db->createCommand("SELECT COUNT(*) FROM $this->table_today")->queryScalar();
	}

	/**
	 * @param DateTime $day
	 *
	 * @return int
	 */
	public function getCountForDay($day)
	{
		if ((new DateTime())->format('Y-m-d') == $day->format('Y-m-d'))
			return $this->getTodayCount();

		$fmt = $day->format('Y-m-d');

		$count =  Yii::app()->db->createCommand("SELECT count FROM ms4_hc_stats WHERE date = '$fmt'")->queryScalar();

		return ($count) ? $count : 0;
	}

	//#############################################################

	/**
	 * @return bool
	 */
	private function isBot()
	{
		return (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT']));
	}

	private function tryUpdateStats()
	{
		if ($this->updated)
			return; // Only update once per instance
		$this->updated = true;


		$connection=Yii::app()->db;

		$row = $connection->createCommand("SELECT * FROM $this->table_today")->queryRow();

		if (! $row)
			return false; // nothing to update

		$last_date = new DateTime($row['date']);

		if ($last_date->format('Y-m-d') != (new DateTime())->format('Y-m-d'))
		{
			// Get last count
			$lastday_count = $connection->createCommand("SELECT COUNT(*) FROM $this->table_today")->queryScalar();

			// Insert into stats
			$last_date_fmt = $last_date->format('Y-m-d');
			$connection->createCommand("INSERT INTO $this->table_stats (date, count) VALUES ('$last_date_fmt', $lastday_count)")->execute();

			// Delete today table
			$connection->createCommand("DELETE FROM $this->table_today")->execute();
			return true;
		}
		else
		{
			return false;
		}
	}
} 