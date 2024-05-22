<?php 

class Error{
    protected $code;
    public function __contruct(int $code,string $page="", string $texte="",Exception $error=null){
        $this->code = $code;
        //TODO : log l'erreur 

    }
    

}
class RedirectedError extends Error{
    protected $page;
    public function __contruct(int $code,string $page, string $texte="",Exception $error=null){
        http_response_code($this->code);
        header("Location: ".$this->page);
    }
}
class ErrorPage extends Error{
    public $texte;
    public function __contruct(int $code,string $page="", string $texte= "",Exception $error=null){
        http_response_code($this->code);
        $this->texte=$texte;
        require_once("../templates/vue_error.php");
    }
}
class InternalError extends Error{
    public function __contruct(int $code,string $page= "", string $texte= "",Exception $error=null){

    }
}