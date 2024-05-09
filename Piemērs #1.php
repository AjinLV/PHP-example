<?php
session_start();
$product_ids = array();
//session_destroy();

//check if Add to Cart button has been submitted
if (filter_input(INPUT_POST, 'add_to_cart')){
  if(isset($_SESSION['shopping_cart'])){

      //keep track of how many products are in the shopping cart
      $count = count($_SESSION['shopping_cart']);

      //create sequantial array for matching array keys to product id's
      $product_ids = array_column($_SESSION['shopping_cart'], 'id');

      if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
      $_SESSION['shopping_cart'][$count] = array
        (
          'id' => filter_input(INPUT_GET, 'id'),
          'name' => filter_input(INPUT_POST, 'name'),
          'price' => filter_input(INPUT_POST, 'price'),
          'quantity' => filter_input(INPUT_POST, 'quantity')
        );
      }
      else { //product already exists, increase quantity 
        //match array key to id of product being added to cart
        for ($i = 0; $i < count($product_ids); $i++){
          if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
            //add item quantity to existing product in array
            $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
          }
        }
      }
  }
  else{ 
        $_SESSION['shopping_cart'][0] = array
        (
          'id' => filter_input(INPUT_GET, 'id'),
          'name' => filter_input(INPUT_POST, 'name'),
          'price' => filter_input(INPUT_POST, 'price'),
          'quantity' => filter_input(INPUT_POST, 'quantity')
        );
  }
}
if(filter_input(INPUT_GET, 'action') == 'delete'){
    //loop trough all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if($product['id'] == filter_input(INPUT_GET, 'id')){
            //remove product from the shopping cart when it matches with GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    //reset session array keys so they match with $product_ids
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}
//pre_r($_SESSION);

function pre_r($array){
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}
?>