<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function post()
    {
        $this->load->view("templates/post.php");
    }
}
