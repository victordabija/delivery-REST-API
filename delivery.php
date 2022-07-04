<?php 

require_once "db.php";
require_once "api.php";

class Delivery extends API{

    /**
     * Calculate the cost of delivery
     * @input int
     * @return float
     */
    private function delivery_cost( $weight, $distance ){
        $cost_per_km = 0.8; // Cost of 1km delivery

        if ( $weight < 5 ){
            $cost = 10; 
        }elseif( $weight > 5 && $weight < 15  ){
            $cost = 20;
        }elseif( $weight > 15 ){
            $cost = 40;
        }

        $cost += ( (float) $cost_per_km * $distance );
        return $cost;
    }

    /**
     * Method POST
     * Send the cost of delivery to user
     * @input int
     * URI: https://domain/api/calculate
     * @return string
     */
    public function calculate( $weight, $distance ){
        if ( empty( $weight ) || empty(  $distance) ) {
            return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
            die();  
        }

        if ( !is_int( $weight ) || !is_int( $distance ) ) {
            return $this->response(Array('code' => 400, 'message' => 'Parameters have to be type int'), 400);
            die();
        }

        $weight /= 1000; // transform grams to kilograms

        $delivery['code'] = 200;
        $delivery['delivery_cost'] = $this->delivery_cost( $weight, $distance );

        if ( $delivery['delivery_cost'] ) {
            return $this->response($delivery, 200);
        }else{
            return $this->response(Array('code' => 500, 'message' => 'Internal Server Error'));
        }
    }

    /**
     * Method POST
     * Create a new delivery order
     * @input array
     * URI: https://domain/api/create
     * @return string
    */
    public function create( $data ){
        if ( !isset($data) ) {
            return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
            die();
        }

        // Checking for empty fields
        foreach ($data as $value) {
            if ( empty($value) ) {
                return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
                die();
            }
        }

        // Checking type of weight and distance variables
        if ( !is_int( $data['weight'] ) || !is_int( $data['distance'] ) ){
            return $this->response(Array('code' => 400, 'message' => 'Parameters have to be type int'), 400);
            die();
        }

        $db = new Db();
        $user = $db->findByID($data['user_id']);

        if ( $user ){
            $hash = substr( $user['password'], 0, 60 );
            if ( !password_verify( $data['password'], $hash ) ){
                return $this->response( Array('code' => 400, 'message' => 'Authorization Failed. Incorrect Password'), 400 );
            }else{
                $data['delivery_cost'] = $this->delivery_cost( $data['weight'] / 1000, $data['distance'] );

                $order_id = $db->createOrder($data);
                if ( $order_id ){
                    $response = [
                        'code'          =>  200,
                        'order_id'      =>  $order_id,
                        'delivery_cost' =>  $data['delivery_cost']
                    ];
                    return $this->response( $response, 200 );
                }else{
                    return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
                }
            }
        }else{
            return $this->response( Array('code' => 400, 'message' => 'Authorization Failed. No User With Given ID'), 400 );
        }
    }

    /**
     * Method POST
     * Create a new user
     * @input array
     * URI: https://domain/api/new_user
     * @return string
     */
    public function newUser( $data ){
        if ( !isset($data) ) {
            return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
            die();
        }

        foreach ($data as $value) {
            if ( empty($value) ) {
                return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
                die();
            }
        }

        $db = new Db();
        $response = $db->createUser( $data );

        if ( $response ){
            $response['code'] = 200;
            return $this->response($response, 200);
        }else{
            return $this->response(Array('code' => 500, 'message' => 'Internal Server Error'));
        }
    }

    /**
     * Method POST
     * Returns order by order_id
     * @inpyt array
     * URI: https://domain/api/get_order
     * @return string
     */
    public function getOrder( $data ){
        if ( !isset($data) ) {
            return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
            die();
        }

        // Checking for empty fields
        foreach ($data as $value) {
            if ( empty($value) ) {
                return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
                die();
            }
        }

        $db = new Db();
        $user = $db->findByID($data['user_id']);

        if ( $user ){
            $hash = substr( $user['password'], 0, 60 );
            if ( !password_verify( $data['password'], $hash ) ){
                return $this->response( Array('code' => 400, 'message' => 'Authorization Failed. Incorrect Password'), 400 );
            }else{
                $order = $db->getOrder( $data['user_id'], $data['order_id'] );
                if ( $order ) {
                    return $this->response( $order, 200 );
                }else{
                    return $this->response( Array('code' => 200, 'message' => 'No Orders With Given ID'), 200 );
                }
            }   
        }else{
            return $this->response( Array('code' => 400, 'message' => 'Authorization Failed. No User With Given ID'), 400 );
        }
    }

    /**
     * Method POST
     * Returns all orders by user_id
     * @input array
     * URI: https://domain/api/get_orders
     * @return  
     */
    public function getOrders( $data ){
        if ( !isset($data) ) {
            return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
            die();
        }

        // Checking for empty fields
        foreach ($data as $value) {
            if ( empty($value) ) {
                return $this->response( Array('code' => 400, 'message' => 'Bad Request'), 400 );
                die();
            }
        }

        $db = new Db();
        $user = $db->findByID($data['user_id']);

        if ( $user ){
            $hash = substr( $user['password'], 0, 60 );
            if ( !password_verify( $data['password'], $hash ) ){
                return $this->response( Array('code' => 400, 'message' => 'Authorization Failed. Incorrect Password'), 400 );
            }else{
                $orders = $db->getOrders( $data['user_id'] );

                if ( $orders ){
                    return $this->response( $orders, 200 );
                }else{
                    return $this->response( Array( 'code' => 200, 'message' => 'User With Given ID doesn`t have orders' ) );
                }  
            }   
        }else{
            return $this->response( Array('code' => 400, 'message' => 'Authorization Failed. No User With Given ID'), 400 );
        }
    }
}

?>