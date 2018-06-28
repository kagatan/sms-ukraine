<?php

namespace Kagatan\SmsUkraine;


class SmsUkraine
{
    /**
     * Server
     *
     * @var string
     */
    protected $server = 'https://alphasms.com.ua/api/http.php';


    /**
     * API key
     *
     * @var null
     */
    protected $key = null;


    /**
     * API Login
     *
     * @var null
     */
    protected $login = null;


    /**
     * API Pass
     *
     * @var null
     */
    protected $password = null;

    /**
     * From
     *
     * @var null
     */
    protected $from = null;

    /**
     * Last response
     *
     * @var array
     */
    private $_last_response = array();

    /**
     * Errors
     *
     * @var array
     */
    protected $_errors = array();


    public function __construct($params)
    {
        if (isset($params['key'])) {
            $this->key = $params['key'];
        }

        if (isset($params['login'])) {
            $this->login = $params['login'];
        }

        if (isset($params['password'])) {
            $this->password = $params['password'];
        }

        if (isset($params['from'])) {
            $this->from = $params['from'];
        }
    }


    /**
     * Send SMS
     *
     * @param $params
     * @return string
     */
    public function send($params = array())
    {
        if (!isset($params['from'])) {
            $params['from'] = $this->from;
        }

        $result = $this->execute('send', $params);

        if (isset($result['id'])) {
            return $result['id'];
        } else {
            return '';
        }
    }


    /**
     * Get balance
     *
     * @param array $params
     * @return string
     */
    public function getBalance($params = array())
    {
        $result = $this->execute('balance', $params);

        if (isset($result['balance'])) {
            return $result['balance'];
        } else {
            return '';
        }
    }


    /**
     * Get status SMS
     *
     * @param $sms_id
     * @param array $params
     * @return string
     */
    public function receiveSMS($sms_id, $params = array())
    {
        $params['id'] = $sms_id;

        $result = $this->execute('receive', $params);

        if (isset($result['status'])) {
            return $result['status'];
        } else {
            return '';
        }
    }


    /**
     * Send request
     *
     * @param $command
     * @param array $params
     * @return mixed|null
     */
    protected function execute($command, $params = array())
    {
        //Использовать параметры из конфига
        if (!isset($params['key'], $params['login'], $params['password'])) {

            //Определяем способ авторизации:
            //- по ключу
            //- по связке логин/пароль
            if(!empty($this->key)){
                $params['key'] = $this->key;
            }else{
                $params['login'] = $this->login;
                $params['password'] = $this->password;
            }
        }

        $params['command'] = $command;

        $data = array();
        foreach ($params as $key => $value) {
            $data[$key] = $this->base64_url_encode($value);
        }

        //cURL HTTPS POST
        $ch = curl_init($this->server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = @curl_exec($ch);
        curl_close($ch);

        $this->_last_response = @unserialize($this->base64_url_decode($response));

        if (isset($this->_last_response['errors'])) {
            $this->_errors = $this->_last_response['errors'];
        }

        return $this->_last_response;
    }

    /**
     * Get last response
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->_last_response;
    }

    /**
     * Return array of errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Returns number of errors
     * @return int
     */
    public function hasErrors()
    {
        return count($this->_errors);
    }


    private function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }


    private function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }
}