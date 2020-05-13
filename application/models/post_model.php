<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class post_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get()   /*取得所有發文資料*/
    {
        $query = $this->db->query('SELECT * FROM `post`');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function post($title, $content) /*發表文章*/
    {
        $data = array(
            'title' => $title,
            'content' => $content
        );
        $sql = $this->db->insert('post', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) /*透過文章id刪除文章*/
    {
        $this->db->where('id', $id);
        $this->db->delete('post');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $content) /*透過文章id更改文章內容*/
    {
        $data = array(
            'content' => $content
        );
        $this->db->where('id', $id);
        $this->db->update('post', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function evaluationgp($id)
    {
        $sql = "SELECT `gp` FROM `post` WHERE `id`= ?";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $row->gp++;
            $data = array(
                'gp' => $row->gp
            );
            $this->db->where('id', $id);
            $this->db->update('post', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function evaluationbp($id)
    {
        $sql = "SELECT `bp` FROM `post` WHERE `id`= ?";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $row->bp++;
            $data = array(
                'bp' => $row->bp
            );
            $this->db->where('id', $id);
            $this->db->update('post', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function search($match)
    {

        $query = $this->db->like('title', $match, 'both');
        $query = $this->db->or_like('content', $match, 'both');
        $query->order_by('id', 'ASC');
        $result = $this->db->get('post');
        if ($this->db->affected_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }   
    }
}
