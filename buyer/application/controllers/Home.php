<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
        redirect(base_url('user'));
		//redirect('http://cn.bing.com/');
	}
}