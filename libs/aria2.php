<?php
class Aria2 {
    protected $ch;

    public function __construct($server = 'http://127.0.0.1:6800/jsonrpc') {
        $this->ch = curl_init($server);
        curl_setopt_array($this->ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
        ]);
    }

    protected function req($data) {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return curl_exec($this->ch);
    }

    public function __call($name, $arg) {
        $data = [
            'jsonrpc' => '2.0',
            'id' => '1',
            'method' => 'aria2.' . $name,
            'params' => $arg,
        ];
        $data = json_encode($data);
        $response = $this->req($data);
        if ($response === false) {
            trigger_error(curl_error($this->ch));
        }
        return json_decode($response, 1);
    }

    public function __destruct() {
        curl_close($this->ch);
    }
}