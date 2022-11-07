<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Api extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->model('AuthModel');
       $this->load->model('MainModel');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function current_weather_get()
	{
        // Get data current weather
        $column = 'coord_lat, coord_lon, timezone, main_pressure, main_humidity, wind_speed, created_at';
        $resultWeather = $this->MainModel->getWeather($column);

        // Check data kosong atau tidak
        $num = $resultWeather['result']->num_rows();
		if ( empty($num) || $num == 0 ) {
			$response = array (
                'code'      => 500,
                'message'   => 'Data tidak ditemukan'
            );
            $this->response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			return;
		}

        // Jika data tidak kosong
        $data = $resultWeather['result']->result_array();
        $response = array (
            'code'      => 200,
            'data'      => $data
        );
        $this->response($response, REST_Controller::HTTP_OK);
        return;
	}

	public function weather_get()
	{
        // Get data list weather
        $column = 'weather_id, weather_main, weather_description, created_at';
        $resultWeather = $this->MainModel->get($column);

        // Check data kosong atau tidak
        $num = $resultWeather['result']->num_rows();
		if ( empty($num) || $num == 0 ) {
			$response = array (
                'code'      => 500,
                'message'   => 'Data tidak ditemukan'
            );
            $this->response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			return;
		}

        // Jika data tidak kosong
        $data = $resultWeather['result']->result_array();
        $response = array (
            'code'      => 200,
            'data'      => $data
        );
        $this->response($response, REST_Controller::HTTP_OK);
        return;
	}
      
    public function login_post()
    {
        // Check body post
        if ( empty($this->post('email')) || empty($this->post('password')) ) {
            $response = array (
                'code'      => 400,
                'message'   => 'Email atau password tidak boleh kosong'
            );
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
			return;
        }

        // Check login
		$column = 'id, email, password, firstname, lastname, phone_number';
		$where = array(
			'LOWER(email)' 		=> $this->post('email')
		);

		$resultLogin = $this->AuthModel->get($column, $where);

		// Check email in db
		$num = $resultLogin['result']->num_rows();
		if ( empty($num) || $num == 0 ) {
			$response = array (
                'code'      => 401,
                'message'   => 'Email belum terdaftar silahkan daftar terlebih dahulu'
            );
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			return;
		}

		// Check password in db
		$password = $resultLogin['result']->row()->password;
		if (!password_verify($this->post('password'), $password)) {
			$response = array (
                'code'      => 401,
                'message'   => 'Password salah, silakan coba lagi'
            );
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			return;
		}

        // Set Session
		$session = array(
			'id'			=> $resultLogin['result']->row()->id,
			'email'			=> $resultLogin['result']->row()->email,
			'name'			=> $resultLogin['result']->row()->firstname.' '.$resultLogin['result']->row()->lastname,
			'phone'			=> $resultLogin['result']->row()->phone_number
		);

        // Response Success
        $response = array (
            'code'      => 200,
            'message'   => 'Anda telah berhasil login',
            'data'      => $session
        );
        $this->response($response, REST_Controller::HTTP_OK);
        return;
    } 
     
    // /**
    //  * Get All Data from this method.
    //  *
    //  * @return Response
    // */
    // public function index_put($id)
    // {
    //     $input = $this->put();
    //     $this->db->update('items', $input, array('id'=>$id));
     
    //     $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    // }
     
    // /**
    //  * Get All Data from this method.
    //  *
    //  * @return Response
    // */
    // public function index_delete($id)
    // {
    //     $this->db->delete('items', array('id'=>$id));
       
    //     $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    // }
    	
}