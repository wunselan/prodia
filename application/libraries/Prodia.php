<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

    class Prodia
    {
        private $CI;
    
        function __construct()
        {
            $this->CI = get_instance();
            require_once 'application/libraries/JWT.php';   
            require_once 'application/libraries/ExpiredException.php';
            require_once 'application/libraries/SignatureInvalidException.php';
            require_once 'application/libraries/BeforeValidException.php';         
        }

        public function create_user_session($data)
        {	
            $token = $this->create_user_token($data);
            $this->CI->session->set_tempdata('token', $token, 3600 * 24 * 1);
        }

        public function create_user_token($data)
        {
            $key = base64_encode('prodia-123');
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+24 hours')->getTimestamp();  // 24 hours jwt expired
            $payload = array(
                'id'        => $data['id'],
                'name'      => $data['name'],
                'email'     => $data['email'],
                'phone'     => $data['phone'],
                "iat"       => $issuedAt->getTimestamp(),
                "exp"       => $expire
            );

            $jwt = JWT::encode($payload, $key);
            return $jwt;
        }

        public function isLogin()
        {
            if ( empty($this->CI->session->userdata('token')) ) {
                return false;
            }

            try {
                $bool = false;
                $token = $this->CI->session->userdata('token');
                $key = base64_encode('prodia-123');
                $decoded = JWT::decode($token, $key, array('HS256'));
                if ( $decoded ) {
                    $bool = true;
                }
                return $bool;
            } catch (\Exception $e) {
                
            } catch (\Firebase\JWT\ExpiredException $e) {

            } catch (\Firebase\JWT\SignatureInvalidException $e) {
            
            } catch (\Firebase\JWT\BeforeValidException $e) {
            
            } catch (\DomainException $e) {
            
            } catch (\InvalidArgumentException $e) {
            
            } catch (\UnexpectedValueException $e) {
            
            }
        }

        public function session_user()
        {
            if ( empty($this->CI->session->userdata('token')) ) {
                return false;
            }

            try {
                $token = $this->CI->session->userdata('token');
                $key = base64_encode('prodia-123');
                $decoded = JWT::decode($token, $key, array('HS256'));
                return (array)$decoded;
            } catch (\Exception $e) {
                
            } catch (\Firebase\JWT\ExpiredException $e) {

            } catch (\Firebase\JWT\SignatureInvalidException $e) {
            
            } catch (\Firebase\JWT\BeforeValidException $e) {
            
            } catch (\DomainException $e) {
            
            } catch (\InvalidArgumentException $e) {
            
            } catch (\UnexpectedValueException $e) {
            
            }
        }

        function dateIndonesia($tanggal)
        {
            $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $split = explode('-', $tanggal);
            return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        }

        function validationError($errors=[])
        {
            $fields = array_keys($errors);
            $err_msg = $errors[$fields[count($errors)-1]];
            return $err_msg;
        }

        public function getAPI($url="", $params=""){

            $headers = array(
                'Content-Type: application/json'
            );

            $url = $url.$params;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            $result = curl_exec($ch);

            // var_dump(curl_error($ch));die();
            if (curl_errno($ch)) {
                return curl_error($ch);
            }

            $result = json_decode($result, true);

            curl_close($ch);
            return $result;
        }

        public function postAPI($url="", $body=""){
            $headers = array(
                'Content-Type: application/json'
            );

            $url = $url;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            
            // var_dump(curl_error($ch));die();	
            if (curl_errno($ch)) {
                return curl_error($ch);
            }

            $result = json_decode($result, true);

            curl_close($ch);
            return $result;
        }

    }
?>