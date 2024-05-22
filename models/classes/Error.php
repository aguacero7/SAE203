<?php
/*
    Classe principale dont hériteront toutes les erreurs
*/
class Error {
    protected $code;
    protected $log_text;
    protected $log_file ="../assets/logs.txt";
    protected $error_type;

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

    public function logit() {
        $ip=$_SERVER["remote_addr"];
        
        // Implementation de la fonction logit()
    } 

    public function __construct(int $code = 200, string $page = "", string $texte = "", Exception $error = null) {
        $this->code = $code;
        // TODO : log l'erreur 
    }
}

/*
    Classe pour rediriger vers une autre page avec un code de retour
*/
class RedirectedError extends Error { // s'appelle avec new RedirectedError({code},{page}); Facultatif : error 
    private $page;

    public function __construct(int $code = Error::HTTP_CODES['FORBIDDEN'], string $page, string $texte = "", Exception $error = null) {
        $this->error_type = "REDIRECTED_ERROR";
        $this->page = $page;
        $this->log_text=$this->error_type."AHAAAAAAAAAAAAAAAAAA";
        parent::__construct($code, $page, $texte, $error); 
        http_response_code($this->code);
        header("Location: " . $this->page);
    }
}

/*
    Classe pour afficher une page d'erreur avec un code de retour indiqué ainsi qu'un certain texte
*/
class ErrorPage extends Error { // s'appelle avec new ErrorPage({code},{texte}); Facultatif : error
    public $texte;
    protected $error_type = "ERROR_PAGE";

    public function __construct(int $code, string $page = "", string $texte, Exception $error = null) {
        $this->texte = $texte;
        parent::__construct($code, $page, $texte, $error); 
        http_response_code($this->code);
        // TODO : log l'erreur
        require_once("../templates/vue_error.php");
    }
}

/*
    Classe pour logger une erreur du serveur (dans le traitement etc)
*/
class InternalError extends Error {
    protected $error_type = "INTERNAL_ERROR";

    public function __construct(int $code = Error::HTTP_CODES['INTERNAL_SERVER_ERROR'], string $page = "", string $texte = "", Exception $error = null) {
        parent::__construct($code, $page, $texte, $error); 
    }
}

/*
    Classe pour logger une erreur dans un but de debgug avec un certain texte
*/
class DebugError extends Error { // s'appelle avec new DebugError({texte}); Facultatif : tout ?
    protected $error_type = "DEBUG_ERROR";

    public function __construct(int $code = 200, string $page = "", string $texte = "", Exception $error = null) {
        parent::__construct($code, $page, $texte, $error); 
    }
}
