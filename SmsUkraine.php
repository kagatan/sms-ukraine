<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 14.06.2018
 * Time: 1:47
 */

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
     * @var string
     */
    protected $apiKey = false;


    /**
     * API Login
     *
     * @var bool
     */
    protected $apiLogin = false;


    /**
     * API Pass
     *
     * @var bool
     */
    protected $apiPassword = false;


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


    public function __construct($param)
    {
        if (isset($param['api_key'])) {
            $this->apiKey = $param['api_key'];
        }

        if (isset($param['api_login'])) {
            $this->apiLogin = $param['api_login'];
        }

        if (isset($param['api_password'])) {
            $this->apiPassword = $param['api_password'];
        }
    }

    /**
     * Set custom param
     *
     * @param $param
     */
    public function set($param)
    {
        if (isset($param['server'])) {
            $this->server = $param['server'];
        }

        if (isset($param['key'])) {
            $this->apiKey = $param['key'];
        }

        if (isset($param['login'])) {
            $this->apiLogin = $param['login'];
        }

        if (isset($param['password'])) {
            $this->apiPassword = $param['password'];
        }
    }


    /**
     * Send SMS
     *
     * @param $data
     * @return string
     */
    public function send($data)
    {
        $result = $this->execute('send', $data);

        if (isset($result['id'])) {
            return $result['id'];
        } else {
            return '';
        }
    }



    /**
     * Get balance
     *
     * @return string
     */
    public function getBalance()
    {
        $result = $this->execute('balance');

        if (isset($result['balance'])) {
            return $result['balance'];
        }else{
            return '';
        }
    }


    /**
     * Get status SMS
     *
     * @param $sms_id
     * @return string
     */
    public function receiveSMS($sms_id)
    {
        $result = $this->execute('receive', ['id' => $sms_id]);

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
        $params['command'] = $command;

        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        } else {
            $params['login'] = $this->apiLogin;
            $params['password'] = $this->apiPassword;
        }

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