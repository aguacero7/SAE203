<?php
/*
    Classe principale dont hériteront toutes les erreurs
*/
class Erreur {
    protected $code;
    protected $log_text;
    protected $log_file = "../assets/logs.txt";
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
        $ip = $_SERVER["REMOTE_ADDR"];
        
        // Implementation de la fonction logit()
        $log_text = date('Y-m-d H:i:s') . " " . $ip . " " . $this->code . " " . $this->error_type . " " . $this->log_message . "\n";
        file_put_contents($this->log_file, $log_text, FILE_APPEND );
    }

    public function __construct(int $code = 200, string $texte = "", string $page = "", Exception $error = null) {
        $this->code = $code;
        $this->log_message = $texte;
        $this->logit();
    }
}

/*
    Classe pour rediriger vers une autre page avec un code de retour
*/
class RedirectedError extends Erreur {
    private $page;

    public function __construct(string $page,int $code = Erreur::HTTP_CODES['FORBIDDEN'],  string $texte = "", Exception $error = null) {
        $this->error_type = "REDIRECTED_ERROR";
        $this->page = $page;
        parent::__construct($code, $texte, $page, $error); 
        http_response_code($this->code);
        header("Location: " . $this->page);
    }
}

/*
    Classe pour afficher une page d'erreur avec un code de retour indiqué ainsi qu'un certain texte
*/
class ErrorPage extends Erreur {
    public $texte;
    protected $error_type = "ERROR_PAGE";

    public function __construct(int $code, string $texte, string $page = "", Exception $error = null) {
        $this->texte = $texte;
        $x =$texte;
        parent::__construct($code, $texte, $page, $error); 
        http_response_code($this->code);
        require_once("../templates/vue_error.php");
    }
}

/*
    Classe pour logger une erreur dans un but de debgug avec un certain texte
*/
class DebugError extends Erreur {
    protected $error_type = "DEBUG_ERROR";

    public function logit() {
        $ip = $_SERVER["REMOTE_ADDR"];
        
        // Implementation de la fonction logit()
        $log_text = date('Y-m-d H:i:s') . " " . $this->error_type . " " . $this->log_message . "\n";

        file_put_contents($this->log_file, $log_text, FILE_APPEND);
    }

    public function __construct(string $texte) {
        $this->log_message = $texte;
        $this->logit();
    }
}

