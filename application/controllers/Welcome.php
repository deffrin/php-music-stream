<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller

{

 public function index()
 {
  $browse = browse('songs');
  $this->load->view('welcome_message', array(
   'browse' => $browse
  ));
 }

 public function view()
 {
  
  $this->load->view('view');
 
 }

 public function refresh()

 {
  // $current_directory="";
  listFolderFiles('songs');
 }
 public function open()
{
  $folder = $this->input->post('open');
  echo browse($folder);
 }

public function add_to_play_list()
{
  $title = $this->input->post('title');
  $mp3 = $this->input->post('mp3');

  if($this->session->userdata('playlist'))
  {
    $playlist = $this->session->userdata('playlist');
    
    $playlist[] = array('title'=>$title,'mp3'=>$mp3);

  }
  else
  {
    $playlist = array();

    $playlist[] = array('title'=>$title,'mp3'=>$mp3);



  }
  
  $this->session->set_userdata('playlist',$playlist);
  print_r($playlist);

}

function get_playlist()
{
  $playlist = $this->session->userdata('playlist');
  $playlist = array_reverse($playlist);
  echo json_encode($playlist);
}

function upload()
{

          $path = $this->input->post('path');
          $config['upload_path']          = "./".$path."/";
          $config['allowed_types']        = 'mp3';
 
          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('file'))
          {
                  $error = array('error' => $this->upload->display_errors());

                  print_r($error);
          }
          else
          {
                  $data = array('upload_data' => $this->upload->data());

                  print_r($data);
          }
}

}