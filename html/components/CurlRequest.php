<?php
namespace app\components;

use Yii;
use app\components\curl\Curl;
use app\components\security\JWT;

class CurlRequest {

    /**
     * Creates Access Token
     *
     * Using service user credentials, access token will be created
     *
     * @return array AccessToken payload or False if something is wrong
     */
    public static function createAccessTokenCall() {
        Curl::init()->setHeader('USER_ID', Yii::$app->params['serviceUser']);
        Curl::init()->setHeader('USER_SECRET', Yii::$app->params['serviceUserSecret']);
        $response = Curl::init()->post(Yii::$app->params['accessServerURL'] . '/token');
        if (empty($response->data->accessToken)) {
            return false;
        }
        /* saving all data into session */
        Yii::$app->session->set('accessTokenPayload', json_encode($response->data));
        return $response->data;
    }

    /**
     * Check if the accessToken has access to the apps or not
     *
     * Requesting accessToken is verified- whether the requesting accessToken has access or not
     *
     * @param string $token requesting accessToken
     * @param string $appID requesting appID
     * @return accessToken payload or return false if it's invalid
     */
    public static function checkAccessTokenCall($token, $appID) {
        Curl::init()->setHeader('accessToken', $token);
        Curl::init()->setHeader('applicationID', $appID);
        $response = Curl::init()->get(Yii::$app->params['accessServerURL'] . '/token');
        if (empty($response->data->accessToken)) {
            return false;
        }
        return $response->data;
    }

    /**
     * Making CURL request
     *
     * Making CURL request to another api
     *
     * @param string $url Full URL
     * @param string $method GET|POST|DELETE|PATCH|OPTIONS
     * @param array $options ['data' => [], 'header'=> []]
     *
     * @return array API response
     */
    public static function apiCall($url, $method = 'GET', $options = array()) {
        //Curl::init();
        Curl::reset();
        if (isset($options['header']) && !empty($options['header'])) {
            foreach ($options['header'] as $key => $val) {
                Curl::init()->setHeader($key, $val);
            }
        }
        //don't verify ssl for now
        Curl::init()->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        Curl::init()->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        Curl::init()->setHeader('timezone', 'America/Denver');

        // create JWT
        $token = JWT::encode([], Yii::$app->params['API_KEY']);
        Curl::init()->setHeader('Authorization', 'Bearer ' . $token);

        $submittedData = isset($options['data']) ? $options['data'] : [];
        switch (strtolower($method)) {
            case "get":
                $response = Curl::init()->get($url, $submittedData);
                break;
            case "post":
                $response = Curl::init()->post($url, $submittedData);
                break;
            case "put":
                $response = Curl::init()->put($url, $submittedData);
                break;
            case "patch":
                $response = Curl::init()->patch($url, $submittedData);
                break;
            case "delete":
                $response = Curl::init()->delete($url, [], $submittedData);
                break;
            case "option":
                $response = Curl::init()->option($url, $submittedData);
                break;
            default:
                throw new \yii\web\BadRequestHttpException("UNKNOWN METHOD: '" . $method . "'");
        }
        Curl::init()->close();
        return $response;
    }

}
