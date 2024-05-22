<?php 

class Error{
    private $code;
    private $log_text;
    private $log_file /*= PATH*/ ;
    private $error_type;
    public const HTTP_CODES = [
        'OK' => 200,
        'CREATED' => 201,
        'NO_CONTENT' => 204,
        'BAD_REQUEST' => 400,
        'UNAUTHORIZED' => 401,
        'FORBIDDEN' => 403,
        'NOT_FOUND' => 404,
        'METHOD_NOT_ALLOWED' => 405,
        'INTERNAL_SERVER_ERROR' => 500,
        'NOT_IMPLEMENTED' => 501,
        'BAD_GATEWAY' => 502,
        'SERVICE_UNAVAILABLE' => 503,
    ];
    /*TODO function logit(){

    }*/
    public function __contruct(int $code,  string $page="",   string $texte="",  Exception    $error=null){
        $this->code = $code;
        //TODO : log l'erreur 

    }
    

}
class RedirectedError extends Error{
    private $page;
    public function __contruct(int $code=Error::HTTP_CODES["FORBIDDEN"],    string $page,    string $texte="",   Exception $error=null){
        parent::__construct($code, $page); // Appel du constructeur parent
        http_response_code($this->code);
        header("Location: ".$this->page);
        
    }
}
class ErrorPage extends Error{
    public $texte;
    private $error_type = "ERROR_PAGE";

    public function __contruct(int $code,string $page="", string $texte,Exception $error=null){
        parent::__construct($code, $texte, $error); // Appel du constructeur parent
        http_response_code($this->code);
        $this->texte=$texte;
        require_once("../templates/vue_error.php");
    }
}
class InternalError extends Error{
    public function __contruct(int $code,string $page= "", string $texte= "",Exception $error=null){
    }
}