<?php
/**
* Simple class that will iterator over a list of full URLs and download the content to an output directory.
*
* Author: Cory Steelman
* Version: 0.1
**/

	class DownloadAll {

		private $listFile = './urls.txt';
		private $list;
		private $outputPath = './output/'; //Must have trailing slash!

		public function run() {
			$this->list = file_get_contents($this->listFile);
			if($this->list === false) {
				throw new \Exception("No file found. The path used was: {$this->listFile}", 1);
			}

			$this->list = explode("\n", $this->list);

			if( !is_array($this->list) || empty($this->list) ) {
				throw new \Exception("Your url file was not setup properly or was empty. Please double check your {$this->listFile} file.", 1);
			}

			$this->log("Output path: {$this->outputPath}");
			foreach($this->list as $i) {
				if(filter_var($i, FILTER_VALIDATE_URL)) {
					$this->curlFile($i);
				} else {
					$this->log("Not a URL: {$i}");
				}
			}

		}

		private function curlFile($url) {
			$fileName = basename($url);

			$writeFile = fopen($this->outputPath . $fileName, 'w');

			$curlData = array();
			// create curl resource
			$ch = curl_init();
			// set url
			curl_setopt($ch, CURLOPT_URL, $url);
			// the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FILE, $writeFile);
			// $output contains the output string
			$output = curl_exec($ch);

			// Grab the curl errors if there are any!
			if (curl_error($ch)) {
				$error_msg = curl_error($ch);
			}

			// Close curl resource to free up system resources
			curl_close($ch);
			// Close the fopen handle.
			fclose($writeFile);

			if (isset($error_msg)) {
				$this->log("Skipped URL - Could not grab the URL provided: {$url}");
			} else {
				$this->log("Successfully downloaded: {$fileName}");
			}

		}

		public function log($str, $html = false) {
			if($html === false) {
				echo sprintf("%s \r\n", $str);
			} else {
				echo sprintf('%s <br>', $str);
			}
		}

	}

	$DA = new DownloadAll;
	$DA->run();