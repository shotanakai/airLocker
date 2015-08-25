<?php
class TestShell extends Shell {

 	var $uses = array('Route');

	function main () {
		$csv = array();
		$filename = $this->args[0];
		$createdBy = 'system';
		$modifiedBy = 'system';
		$fp = fopen($filename, "r");
		while (($retCsv = fgetcsv($fp, 0, ",")) !== FALSE) {
			$this->Route->create();
			$routeData = array();
			$routeData['name'] = $retCsv[1];
			$routeData['created'] = null;
			$routeData['created_by'] = $createdBy;
			$routeData['modified_by'] = $modifiedBy;
			debug($routeData);
			if (!$this->Route->save($routeData)) {
				$this->log('import csv shell: These datas could not save.');
			}
		}
		fclose($fp);
	}

	function test2() {
		$this->out('test.');
	}
}