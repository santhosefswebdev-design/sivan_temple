<?php
global $lang, $set_lang;
$default_language = 'english';







if($default_language == 'english'){
    include_once(FCPATH . 'app/Language/english/lang.php');
     $lang = new LangEn();
}elseif($default_language == 'tamil'){
    include_once(FCPATH . 'app/Language/tamil/lang.php');
    $lang = new LangTm();
}else{
     $lang = new LangEn();
}
Class SetLang{
    public function switcher(){
        global $lang;
        $default_language = (!empty($_SESSION['language']) ? $_SESSION['language'] : 'english');
        if($default_language == 'english'){
            include_once(FCPATH . 'app/Language/english/lang.php');
             $lang = new LangEn();
        }elseif($default_language == 'tamil'){
            include_once(FCPATH . 'app/Language/tamil/lang.php');
            $lang = new LangTm();
        }else{
             $lang = new LangEn();
        }
    }
}
$set_lang = new SetLang();