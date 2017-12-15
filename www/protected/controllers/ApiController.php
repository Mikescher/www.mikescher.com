<?php

class APIController extends MSController
{
	public $layout = false;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdate()
	{
		if (! isset($_GET['Name'])) {
			throw new CHttpException(404,'Invalid Request - [Name] missing');
			return;
		}

		$Name = $_GET['Name'];

		$this->actionUpdate2($Name);
	}

	public function actionUpdate2($Name)
	{
		if (! isset($_GET['Name'])) {
			throw new CHttpException(404,'Invalid Request - [Name] missing');
		}

		$data = ProgramUpdates::model()->findByAttributes(['Name' => $Name]);

		if (is_null($data)) {
			throw new CHttpException(404,'Invalid Request - [Name] not found');
		}

		$log = new ProgramUpdatesLog();
        $log->programname = $data->Name;
        $log->version = $data->Version;
        $log->date = date('Y-m-d H:i:s');
        $log->ip = $this->get_client_ip();

        if ($log->ip == MsHelper::getStringDBVar('self_ip')) $log->ip = "self";

        $log->save();

		$this->render('update', ['data' => $data]);
	}

	public function actionStatsPing()
	{
		if (! isset($_GET['Name'])) { throw new CHttpException(404,'Invalid Request'); return; }
		if (! isset($_GET['ClientID'])) { throw new CHttpException(404,'Invalid Request'); return; }
		if (! isset($_GET['Version'])) { throw new CHttpException(404,'Invalid Request'); return; }
		if (! isset($_GET['ProviderStr'])) { throw new CHttpException(404,'Invalid Request'); return; }
		if (! isset($_GET['ProviderID'])) { throw new CHttpException(404,'Invalid Request'); return; }
		if (! isset($_GET['NoteCount'])) { throw new CHttpException(404,'Invalid Request'); return; }

		if ($_GET['Name'] == 'AlephNote') 
		{
			$connection = Yii::app()->db;

			$command=$connection->createCommand("INSERT INTO {{an_statslog}} (ClientID, Version, ProviderStr, ProviderID, NoteCount) VALUES (:cid, :v, :pstr, :pid, :nc) ON DUPLICATE KEY UPDATE Version=:v,ProviderStr=:pstr,ProviderID=:pid,NoteCount=:nc");
			$command->bindValues([
				':cid' => $_GET['ClientID'],
				':v' => $_GET['Version'],
				':pstr' => $_GET['ProviderStr'],
				':pid' => $_GET['ProviderID'],
				':nc' => $_GET['NoteCount'],
			]);
			$command->query();
			$this->render('stats', ['out' => '{"success":true}']);
		}
		else 
		{
			$this->render('stats', ['out' => '{"success":false}']);
		}
	}

    public function actionSetSelfAdress()
    {
        if (! isset($_GET['ip'])) {
            $ip = $this->get_client_ip();
        } else {
            $ip = $_GET['ip'];
        }


        MsHelper::setStringDBVar('self_ip', $ip);

        echo 'Ok.';
        return;
    }

    public function get_client_ip() {
        if (getenv('HTTP_CLIENT_IP'))
            return getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            return getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            return getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            return getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            return getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            return getenv('REMOTE_ADDR');
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            return $_SERVER['REMOTE_ADDR'];
        else
            return 'UNKNOWN';
    }

	public function actionTest()
	{
		$this->render('test', []);
	}
}