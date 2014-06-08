<?php

class MsHelper {
	public static function getStringDBVar($name)
	{
		$connection = Yii::app()->db;

		$command=$connection->createCommand("SELECT SValue FROM {{othervalues}} WHERE Name = '$name'");
		$val = $command->queryScalar();

		return $val;
	}

	public static function getIntDBVar($name)
	{
		$connection = Yii::app()->db;

		$command=$connection->createCommand("SELECT [Value] FROM {{othervalues}} WHERE Name = '$name'");
		$val = $command->queryScalar();

		return $val;
	}
} 