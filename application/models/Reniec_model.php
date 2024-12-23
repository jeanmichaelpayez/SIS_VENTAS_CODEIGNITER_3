<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reniec_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_persona_by_dni($dni) {
        $token = 'apis-token-1306.mRqrufPSvLTD8olQSxmm8KNGxpB4VMZh';
        $url = 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response) {
            return json_decode($response, true);
        } else {
            return false;
        }
    }
}