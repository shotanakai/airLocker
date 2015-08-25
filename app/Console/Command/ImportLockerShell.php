<?php
class ImportLockerShell extends Shell {

 	var $uses = array('Locker');

	function main () {
		$csv = array();
		$filename = $this->args[0];
		$createdBy = 'system';
		$modifiedBy = 'system';
		$fp = fopen($filename, "r");
		while (($retCsv = fgetcsv($fp, 0, ",")) !== FALSE) {
			$this->Locker->create();
			$lockerData = array();
			$lockerData['station_id'] = $retCsv[0];
			$postal_code = $retCsv[1];
			if(strpos($postal_code, "-")) {
				$postal_code = str_replace("-", "", $postal_code);
			}
			$lockerData['postal_code'] = $postal_code;
			$lockerData['address'] = $retCsv[2];
			$lockerData['large_locker'] = $retCsv[3];
			$lockerData['large_locker_fee'] = $retCsv[4];
			$lockerData['medium_locker'] = $retCsv[5];
			$lockerData['medium_locker_fee'] = $retCsv[6];
			$lockerData['small_locker'] = $retCsv[7];
			$lockerData['small_locker_fee'] = $retCsv[8];
			$lockerData['memo'] = $retCsv[9];
			$lockerData['created'] = null;
			$lockerData['created_by'] = $createdBy;
			$lockerData['modified_by'] = $modifiedBy;
			debug($lockerData);
			if (!$this->Locker->save($lockerData)) {
				$this->log('import csv shell: These datas could not save.');
			}
		}
		fclose($fp);
	}
}