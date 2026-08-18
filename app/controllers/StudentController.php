<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['student_access'] = true;
        $data['page_title'] = 'Jolly Roy - Student Home';
        $this->call->view('student_home', $data);
    }

    public function profile()
    {
        $data['page_title'] = 'Jolly Roy - Student Profile';
        $data['student'] = [
            'student_id' => 'MCC2024-00100',
            'name'       => 'Jolly Roy Añonuevo',
            'course'     => 'Bachelor of Science in Information Technology',
            'year'       => '3rd Year',
            'section'    => 'BSIT-3-F2',
            'email'      => 'jollyroyp.anonuevo@mcc.edu.ph',
            'address'    => 'Bangkatan, Baco, Oriental Mindoro',
            'contact'    => '09677504593',
            'skills'     => 'Playing Games',
            'hobbies'    => 'Studying Different Kinds of Motorcycle',
            'bio'        => 'Hey! I\'m Jolly Roy, a 3rd-year IT major at MinSU. Tech student by day, gamer by night, and full-time motorcycle nerd in between.',
            'tiktok'     => '@royyzxxx',
            'facebook'   => 'Jolly Roy Añonuevo',
        ];
        $this->call->view('student_profile', $data);
    }

}
?>
