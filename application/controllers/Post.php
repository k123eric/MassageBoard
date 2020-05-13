<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
    }

    public function get_post()
    {
        $result = $this->post_model->get();

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function release_post()
    {
        $title = isset($_POST["title"]) ? $_POST["title"] : "";
        $content = isset($_POST["content"]) ? $_POST["content"] : "";
        if (empty($title) || empty($content) || strlen($title) > 50 || strlen($content) > 256) {
            echo 0;
        } else {
            echo $this->post_model->post($title, $content);
        }
    }

    public function update_post()
    {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $content = isset($_POST["content"]) ? $_POST["content"] : "";
        if (empty($id) || empty($content) || strlen($content) > 256) {
            echo 0;
        } else {
            echo $this->post_model->update($id, $content);
        }
    }

    public function delete_post()
    {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        if (empty($id)) {
            echo 0;
        } else {
            echo $this->post_model->delete($id);
        }
    }

    public function search_post()
    {
        $match = isset($_POST["match"]) ? $_POST["match"] : "";
        if (empty($match)) {
            echo 0;
        } else {
            $result = $this->post_model->search($match);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    public function evaluation_postgp()
    {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        if (empty($id)) {
            echo 0;
        } else {
            echo $this->post_model->evaluationgp($id);
        }
    }

    public function evaluation_postbp()
    {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        if (empty($id)) {
            echo 0;
        } else {
            echo $this->post_model->evaluationbp($id);
        }
    }
}
