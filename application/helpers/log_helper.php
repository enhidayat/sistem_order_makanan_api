<?php 

function helper_log($tipe = "", $str = ""){
    $CI =& get_instance();

    if (strtolower($tipe) == "login"){
        $log_tipe   = 0;
    }
    elseif(strtolower($tipe) == "logout")
    {
        $log_tipe   = 1;
    }
    elseif(strtolower($tipe) == "add"){
        $log_tipe   = 2;
    }
    elseif(strtolower($tipe) == "edit"){
        $log_tipe  = 3;
    }
    else{
        $log_tipe  = 4;
    }

    //ambil user
    $data['user'] = $CI->db->get_where('user', ['email' => $CI->session->userdata('email')])->row_array();
    $log_user = $data['user']['name'];
        // paramter
    // $param['log_user']      = $CI->session->userdata('name');
    $param['log_user']      = $log_user;
    $param['log_tipe']      = $log_tipe;
    $param['log_desc']      = $str;

        //load model log
    $CI->load->model('m_log');

        //save to database
    $CI->m_log->save_log($param);

}

?>