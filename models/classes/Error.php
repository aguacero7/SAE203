<?php
/*
    Classe principale dont hériteront toutes les erreurs
*/
class Erreur {
    protected $code;
    protected $log_text;
    protected $log_file ="../assets/logs.txt";
    protected $error_type;
    protected $log_message;

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
        $ip=$_SERVER["REMOTE_ADDR"];
        
        // Implementation de la fonction logit()
        $log_text = date('Y-m-d H:i:s') . $ip . $this->code . $this->error_type . $this->log_message ."\n";

        if (file_put_contents($this->log_file, $log_text, FILE_APPEND | LOCK_EX) === FALSE) {
            echo "Impossible d'écrire dans le fichier de log";
        } else {
            echo "Message écrit dans le fichier de log";
        }
       
    } 

    public function __construct(int $code = 200, string $page = "", string $texte = "", Exception $error = null) {
        $this->code = $code;
       $this->logit();
    }
}

/*
    Classe pour rediriger vers une autre page avec un code de retour
*/
class RedirectedError extends Erreur { // s'appelle avec new RedirectedError({code},{page}); Facultatif : error 
    private $page;

    public function __construct(int $code = Error::HTTP_CODES['FORBIDDEN'], string $page, string $texte = "", Exception $error = null) {
        $this->error_type = "REDIRECTED_ERROR";
        $this->page = $page;
        $this->log_text=$this->error_type."";
        parent::__construct($code, $page, $texte, $error); 
        http_response_code($this->code);
        header("Location: " . $this->page);
    }
}

/*
    Classe pour afficher une page d'erreur avec un code de retour indiqué ainsi qu'un certain texte
*/
class ErrorPage extends Erreur { // s'appelle avec new ErrorPage({code},{texte}); Facultatif : error
    public $texte;
    protected $error_type = "ERROR_PAGE";

    public function __construct(int $code, string $page = "", string $texte, Exception $error = null) {
        $this->texte = $texte;
        parent::__construct($code, $page, $texte, $error); 
        http_response_code($this->code);
        require_once("../templates/vue_error.php");
    }
}

/*
    Classe pour logger une erreur du serveur (dans le traitement etc)
*/
class InternalError extends Erreur {
    protected $error_type = "INTERNAL_ERROR";

    public function __construct(int $code = Error::HTTP_CODES['INTERNAL_SERVER_ERROR'], string $page = "", string $texte = "", Exception $error = null) {
        parent::__construct($code, $page, $texte, $error); 
    }
}

/*
    Classe pour logger une erreur dans un but de debgug avec un certain texte
*/
class DebugError extends Erreur { // s'appelle avec new DebugError({texte}); 
    protected $error_type = "DEBUG_ERROR";
    public function logit() {
        $ip=$_SERVER["REMOTE_ADDR"];
        
        // Implementation de la fonction logit()
        $log_text = date('Y-m-d H:i:s') ." ".$this->error_type." ".$this->log_message ."\n";

        if (file_put_contents($this->log_file, $log_text, FILE_APPEND | LOCK_EX) === FALSE) {
            echo "Impossible d'écrire dans le fichier de log";
        } else {
            echo "Message écrit dans le fichier de log";
        }
       
    } 
    public function __construct(string $texte) {
        $this->log_message=$texte;
        $this->logit();
    }
}
