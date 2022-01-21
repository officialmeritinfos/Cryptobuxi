<?php
namespace App\Custom;

use Illuminate\Support\Facades\Http;

/**
 * Class Regular
 * @package App\Custom
 */
class Regular{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public $ip_url;
    public $ip_api;

    /**
     * Regular constructor.
     */
    public function __construct(){
        $this->ip_url = 'https://api.ipgeolocation.io/';
        $this->ip_api = '11c9dda387af47ed861f623d84fd5f9e';
    }

    /**
     * @return \Illuminate\Http\Client\Response
     * @return only requested country
     */
    public function getUserCountry($ip){
        $response = Http::get($this->ip_url.'ipgeo?apiKey='.$this->ip_api.'&ip='.$ip);
        return $response;
    }
    public function getUserAgent($ip){
        $response = Http::get($this->ip_url.'user-agent?apiKey='.$this->ip_api.'&ip='.$ip);
        return $response;
    }
    public function getUserCountryUserAgent(){
        $response = Http::get($this->ip_url.'ipgeo?apiKey='.$this->ip_api.'&include=useragent');
        return $response;
    }
    public function formatNumbers( $n, $precision = 1){
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
}

