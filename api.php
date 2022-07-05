<?php 

abstract class API{
  
    public $requestUri = [];

    public function __construct(){
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $this->$method = $this->requestUri[1];
    }

    public function run(){
        if(array_shift($this->requestUri) !== 'api' ){
            throw new RuntimeException('API Not Found', 404);
        }

        $json = json_decode( file_get_contents('php://input').PHP_EOL, true );

        switch ($this->$method) {
            case 'calculate':
                    return $this->calculate( $json['weight'], $json['distance'] );
                break; 
                
                case 'create':
                    return $this->create( $json );
                    break;
            
                case 'new_user':
                    return $this->newUser( $json );
                    break;

                case 'get_order':
                    return $this->getOrder( $json );
                    break;

                case 'get_orders':
                    return $this->getOrders( $json );
                    break;

            default:
                return $this->response(Array('code' => 405, 'message' => 'Invalid Method'), 405);
                break;
        }
    }

    protected function response($data, $status = 500){
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }

    private function requestStatus($code){
        $status = [
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not Found',
            405 => 'Invalid Method',
            500 => 'Internal Server Error'
        ];

        return ($status[$code]) ? $status[$code] : $status[500];
    }

    abstract protected function calculate( $weight, $distance );
    abstract protected function create( $data  );
    abstract protected function newUser( $data );
    abstract protected function getOrder( $data );
    abstract protected function getOrders( $data );
}

?>
