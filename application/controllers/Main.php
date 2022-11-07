<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

    public function __construct()
	{
		parent::__construct();
        $this->load->model('MainModel');
		error_reporting(0);
	}

	public function index()
	{   
		// Check login
		if ( !$this->prodia->isLogin() ) {
			$this->session->set_flashdata('error', 'Silahkan masuk terlebih dahulu');
			redirect('masuk');
		}

        // Get data list weather from API
        $url = "http://localhost/prodia/api/current_weather";
        $result = $this->prodia->getAPI($url);
        
        // Check apakah get data
        // Jika response code bukan 200 maka gagal
        if ( $result['code'] !== 200 ) {
            $this->session->set_flashdata('error', 'Gagal mendapatkan data current weather');
            log_message('error', $result);
        }

        $data['cuaca'] = $result['data'];

        // Get data list weather from API
        $url = "http://localhost/prodia/api/weather";
        $result = $this->prodia->getAPI($url);
        
        // Check apakah get data
        // Jika response code bukan 200 maka gagal
        if ( $result['code'] !== 200 ) {
            $this->session->set_flashdata('error', 'Gagal mendapatkan data list weather');
            log_message('error', $result);
        }

        $data['listWeather'] = $result['data'];

        // Pemanggilan View
        $data['content'] = "main/home";
		$this->load->view('template/page_login', $data);
	}

    public function getDataWeather()
    {   
        // Params API
        $params = http_build_query([
            'lat'       => '-6.186695706914009',
            'lon'       => '106.84605910524184',
            'exclude'   => 'current',
            'appid'     => API_KEY
        ]);

        // Result get api 
        $result = $this->prodia->getAPI(LINK_API_WEATHER, $params);
        
        // Check apakah get data
        // Jika response code bukan 200 maka gagal
        if ( $result['cod'] !== 200 ) {
            $this->session->set_flashdata('error', 'Gagal mendapatkan data cuaca');
            log_message('error', $result);
			redirect('');
        }

        // Jika berhasil maka insert data to db
        $data = array(
            'coord_lon' 				=> $result['coord']['lon'],
            'coord_lat'					=> $result['coord']['lat'],
            'weather_id'				=> $result['weather'][0]['id'],
            'weather_main'				=> $result['weather'][0]['main'],
            'weather_description'		=> $result['weather'][0]['description'],
            'weather_icon'				=> $result['weather'][0]['icon'],
            'base'						=> $result['base'],
            'main_temp'					=> $result['main']['temp'],
            'main_feels_like'			=> $result['main']['feels_like'],
            'main_temp_min'				=> $result['main']['temp_min'],
            'main_temp_max'				=> $result['main']['temp_max'],
            'main_pressure'				=> $result['main']['pressure'],
            'main_humidity'				=> $result['main']['humidity'],
            'main_sea_level'			=> $result['main']['sea_level'],
            'main_grnd_level'			=> $result['main']['grnd_level'],
            'visibility'				=> $result['visibility'],
            'wind_speed'				=> $result['wind']['speed'],
            'wind_deg'					=> $result['wind']['deg'],
            'wind_gust'					=> $result['wind']['gust'],
            'clouds_all'				=> $result['clouds']['all'],
            'dt'						=> $result['dt'],
            'sys_type'					=> $result['sys']['type'],
            'sys_id'					=> $result['sys']['id'],
            'sys_country'				=> $result['sys']['country'],
            'sys_sunrise'				=> $result['sys']['sunrise'],
            'sys_sunset'				=> $result['sys']['sunset'],
            'timezone'					=> $result['timezone'],
            'id_loc'					=> $result['id'],
            'name'						=> $result['name'],
            'cod'						=> $result['cod'],
        );

        $resultInsData = $this->MainModel->insert($data);
        if ( !$resultInsData['result'] && $resultInsData['error']['message'] ) {
			$this->session->set_flashdata('error', strip_quotes($resultInsData['error']['message']));
			log_message('error', strip_quotes($resultInsData['error']['message']));
			redirect('');
		}

        $this->session->set_flashdata('success', 'Data cuaca berhasil diperbarui');
        redirect('');
    }
}
