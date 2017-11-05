<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get all customers
$app->get('/api/customers',function (Request $request, Response $response){
    $sql = "SELECT * FROM customers";

    try{
        //Get DB Object
        $db = New DB();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

//Get single customer
$app->get('/api/customer/{id}',function (Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM customers WHERE id = $id";

    try{
        //Get DB Object
        $db = New DB();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

//Add customer
$app->post('/api/customer/add',function (Request $request, Response $response){
    $firstName = $request->getParam('firstName');
    $lastName = $request->getParam('lastName');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $province = $request->getParam('province');

    $sql = "INSERT INTO customers (firstName,lastName,phone,email,address,city,province) VALUES
            (:firstName,:lastName,:phone,:email,:address,:city,:province)";

    try{
        //Get DB Object
        $db = New DB();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':firstName',$firstName);
        $stmt->bindParam(':lastName',$lastName);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':province',$province);

        $stmt->execute();

        echo '{"notice": {"text": "customer added"}}';
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

//update customer
$app->put('/api/customer/update/{id}',function (Request $request, Response $response){

    $id = $request->getAttribute('id');
    $firstName = $request->getParam('firstName');
    $lastName = $request->getParam('lastName');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $province = $request->getParam('province');

    $sql = "UPDATE  customers SET
              firstName = :firstName,
              lastName  = :lastName,
              phone     = :phone,
              email     = :email,
              address   = :address,
              city      = :city,
              province  = :province
            WHERE id = $id";

    try{
        //Get DB Object
        $db = New DB();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':firstName',$firstName);
        $stmt->bindParam(':lastName',$lastName);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':province',$province);

        $stmt->execute();

        echo '{"notice": {"text": "customer updated"}}';
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

//Get single customer
$app->delete('/api/customer/delete/{id}',function (Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM customers WHERE id = $id";

    try{
        //Get DB Object
        $db = New DB();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "customer deleted"}}';
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});