<?php
class ImportStationShell extends Shell {

 	var $uses = array('Station');

	function main () {
		$csv = array();
		$filename = $this->args[0];
		$createdBy = 'system';
		$modifiedBy = 'system';
		$fp = fopen($filename, "r");
		while (($retCsv = fgetcsv($fp, 0, ",")) !== FALSE) {
			$this->Station->create();
			$stationData = array();
			$stationData['name'] = $retCsv[1];
			$stationData['route_ids'] = $retCsv[2];
			$postal_code = $retCsv[3];
			if(strpos($postal_code, "-")) {
				$postal_code = str_replace("-", "", $postal_code);
			}
			$stationData['postal_code'] = $postal_code;
			$stationData['address'] = $retCsv[4];
			$stationData['created'] = null;
			$stationData['created_by'] = $createdBy;
			$stationData['modified_by'] = $modifiedBy;
			debug($stationData);
			if (!$this->Station->save($stationData)) {
				$this->log('import csv shell: These datas could not save.');
			}
		}
		fclose($fp);
	}

	function test2() {
		$this->out('test.');
	}
}