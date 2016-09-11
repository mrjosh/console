<?php

/**
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @version 1.1
 * @package Lemax Libs | iBrowse library
 */

namespace Josh\Libs;

trait iBrowse {

    protected $ch;

    protected $url = 'https://packagist.org/api/update-package';

    /**
     * set the datas
     * @param array $datas
     * @return $this
     */
    public function data(array $datas)
    {
        $this->ch = curl_init(
            $this->url."?username=".trim($datas['username']).'&apiToken='.trim($datas['token'])
        );
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $datas['data']);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($datas['data'])
            )
        );
        return $this;
    }

    /**
     * post the datas to url
     * @return mixed
     */
    public function post()
    {
        $result = curl_exec($this->ch);
        return json_decode($result,true);
    }

}