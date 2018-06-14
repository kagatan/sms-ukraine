<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 14.06.2018
 * Time: 1:47
 */

namespace Kagatan\SmsUkraine;


class SmsUkraineHelper
{

    /**
     * Server
     *
     * @var string
     */
    protected $server = 'https://alphasms.com.ua/api/http.php';


    /**
     * Max error
     *
     * @var int
     */
    protected $maxError = 3;


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
     * Sender from name
     *
     * @var bool
     */
    protected $from = false;


    /**
     * Last response
     *
     * @var null
     */
    private $_last_response = null;


    /**
     * Set custom param
     *
     * @param $param
     */
    public function set($param)
    {
        if (isset($param['mode'])) {
            $this->mode = $param['mode'];
        }
        if (isset($param['server'])) {
            $this->server = $param['server'];
        }

        if (isset($param['maxError'])) {
            $this->maxError = $param['maxError'];
        }

        if (isset($param['apiKey'])) {
            $this->apiKey = $param['apiKey'];
        }

        if (isset($param['apiLogin'])) {
            $this->apiLogin = $param['apiLogin'];
        }

        if (isset($param['apiPassword'])) {
            $this->apiPassword = $param['apiPassword'];
        }


        if (isset($param['from'])) {
            $this->from = $param['from'];
        }
    }


    /**
     * Send SMS
     *
     * @param $data
     * @return mixed|null
     */
    public function send($data)
    {

        return $this->execute('send', $data);
    }


    /**
     * Get balance
     *
     * @return mixed
     */
    public function getBalance()
    {
        $result = $this->execute('balance');
//        var_dump($result);
        ///if (count(@$result['errors']))
//            $this->_errors = $result['errors'];
        return @$result['balance'];
    }


    /**
     * @param $command
     * @param array $params
     * @return mixed|null
     */
    protected function execute($command, $params = array())
    {

        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        } else {
            $params['login'] = $this->apiLogin;
            $params['password'] = $this->apiPassword;
        }

        $params['command'] = $command;

        $params_url = '';
        foreach ($params as $key => $value)
            $params_url .= '&' . $key . '=' . $this->base64_url_encode($value);


        //cURL HTTPS POST
        $ch = curl_init($this->server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = @curl_exec($ch);
        curl_close($ch);

        $this->_last_response = @unserialize($this->base64_url_decode($response));
        return $this->_last_response;
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