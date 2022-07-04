<?php 

    define( 'DB_NAME', 'delivery' );
    define( 'DB_HOST', '127.0.0.1' );
    define( 'DB_USER', 'root' );
    define( 'DB_PASS', '123' );

class Db{
    
    public $connection = NULL;

    public function __construct(){
        $this->$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );

        if ( !$this->$connection ) {
            return "Can't connect to database \n" . mysqli_connect_error();
            exit();
        }
    }

    public function createUser( $data ){
        $query = "INSERT INTO `user` ( username, password ) VALUES ( '".$data['name']."', '".password_hash( $data['password'], PASSWORD_BCRYPT )."' )";
        $state = mysqli_query( $this->$connection, $query);

        if ($state) {
            $data['user_id'] = mysqli_insert_id($this->$connection);   
            return $data;
        }
    }

    public function findByID( $id ){
        $query = "SELECT * FROM `user`WHERE `id` = {$id}";
        $response = mysqli_query( $this->$connection, $query );
        $user = mysqli_fetch_assoc( $response );
        
        if ( $user ) {
            return $user;
        }
    }

    public function createOrder( $data ){
        $user_id        = $data['user_id'];
        $distance       = $data['distance'];
        $from           = $data['from'];
        $to             = $data['to'];
        $weight         = $data['weight'];
        $first_name     = $data['first_name'];
        $last_name      = $data['last_name'];
        $email          = $data['email'];
        $phone          = $data['phone'];
        $zip_code       = $data['zip_code'];
        $delivery_cost  = $data['delivery_cost'];

        $query = "INSERT INTO `order` ( `user_id`, `distance`, `from`, `to`, `weight`, `first_name`, `last_name`, `email`, `phone`, `zip_code`, `delivery_cost` ) VALUES ( {$user_id}, {$distance}, '{$from}', '{$to}', {$weight}, '{$first_name}', '{$last_name}', '{$email}', '{$phone}', '{$zip_code}', {$delivery_cost} )";
        $state = mysqli_query ( $this->$connection, $query );
        
        if ( $state ){
            $order_id = mysqli_insert_id($this->$connection);   
            return $order_id;
        }
    }

    public function getOrder( $user_id, $order_id ){
        $query = "SELECT * FROM `order` WHERE `user_id` = {$user_id} AND `order_id` = {$order_id}";
        $response = mysqli_query( $this->$connection, $query );
        $order = mysqli_fetch_assoc( $response );

        return $order;
    }

    public function getOrders( $user_id ){
        $query = "SELECT * FROM `order` WHERE `user_id` = {$user_id}";
        $response = mysqli_query( $this->$connection, $query );

        while( $orders[] = mysqli_fetch_assoc( $response ) );
        array_pop($orders);

        return $orders;

    }
}

?>