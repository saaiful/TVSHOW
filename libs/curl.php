<?php
class Curl {
	private $ch;
	private $cookie;

	public function __construct() {
		$this->cookie = __DIR__ . "/cookie_" . rand(1, 15000) . '.txt';
		$this->ch = curl_init();
		$this->option(CURLOPT_USERAGENT, $this->agent());
		$this->option(CURLOPT_SSL_VERIFYPEER, false);
		$this->option(CURLOPT_FOLLOWLOCATION, false);
		$this->option(CURLOPT_COOKIESESSION, true);
		$this->option(CURLOPT_VERBOSE, false);
		$this->option(CURLOPT_RETURNTRANSFER, true);
		$this->option(CURLOPT_FRESH_CONNECT, true);
	}

	private function agent() {
		return 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:33.0) Gecko/20100101 Firefox/33.0.2 Waterfox/33.0';
	}

	public function option($name, $value) {
		curl_setopt($this->ch, $name, $value);
	}

	public function get($url, $ref = '') {
		if (!empty($ref)) {
			$this->option(CURLOPT_REFERER, $ref);
		}
		$this->option(CURLOPT_URL, $url);
		$this->option(CURLOPT_POST, false);
		return curl_exec($this->ch);
	}

	public function post($url, $ref = '', $post) {
		if (!empty($ref)) {
			$this->option(CURLOPT_REFERER, $ref);
		}
		$this->option(CURLOPT_URL, $url);
		$this->option(CURLOPT_POST, true);
		$this->option(CURLOPT_POSTFIELDS, http_build_query($post));
		return curl_exec($this->ch);
	}

	public function error() {
		if (curl_error($this->ch)) {
			return curl_error($this->ch);
		} else {
			return false;
		}
	}

	public function cookie() {
		$this->option(CURLOPT_COOKIEJAR, $this->cookie);
		$this->option(CURLOPT_COOKIEFILE, $this->cookie);
	}

	public function ch() {
		return $this->ch;
	}

	public function __destruct() {
		curl_close($this->ch);
		@unlink($this->cookie);
	}
}