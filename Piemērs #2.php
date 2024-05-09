    <div class="cart-container">
      <?php
  
      $connect = mysqli_connect('fdb29.awardspace.net', '3624893_ip18kb', 'kristians1102', '3624893_ip18kb');
      $query = 'SELECT * FROM products ORDER by ID ASC';
      $result = mysqli_query($connect, $query);
  
      if ($result):
          if(mysqli_num_rows($result)>0):
              while($product = mysqli_fetch_assoc($result)):
                //print_r($product);
                ?>
                <div class="col-sm-4 col-md-3" >
                  <form method="post" action="http://kristsip18.atwebpages.com/?action=add$id=<?php echo $product['id']; ?>"
                    <div class="products">
                    <img src="<?php echo $product['image']; ?>" class="img-responsive" />
                    <h4 class="text-info"><?php echo $product['name']; ?></h4>
                    <h4>$ <?php echo $product['price']; ?></h4>
                    <input type="text" name="quantity" class="form-control" value="1" />
                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                    <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart" />
                    </div>
                  </form>
                </div>
                <?php
              endwhile;
          endif;
      endif;
      ?>
      <div style="clear:both"></div>
      <br />
      <div class="table-responsive">
        <table class="cart-table">
          <tr><th><h3>Order Details</h3></tr></th>
        <tr>
          <th width="40%">Product Name</th>
          <th width="10%">Quantity</th>
          <th width="20%">Price</th>
          <th width="15%">Total</th>
          <th width="5%">Action</th>
        </tr>
        <?php
        if(!empty($_SESSION['shopping_cart'])):
          $total = 0;

          foreach($_SESSION['shopping_cart'] as $key => $product):
        ?>
        <tr>
          <td><?php echo $product['name']; ?></td>
          <td><?php echo $product['quantity']; ?></td>
          <td>$<?php echo $product['price']; ?></td>
          <td>$<?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
          <td>
            <a href="http://kristsip18.atwebpages.com/?action=delete&id=<?php echo $product['id']; ?>">
                <div class="btn-danger">Remove</div>
            </a>
          </td>
        </tr>
        <?php
            $total = $total + ($product['quantity'] * $product['price']);
            endforeach;
        ?>
        <tr>
          <td colspan="3" align="right">Total</td>
          <td align="right">$ <?php echo number_format($total, 2); ?></td>
          <td></td>
        </tr>
        <tr>
          <!-- Show checkout button only if the shopping cart is not empty -->
          <td colspan="5">
            <?php 
              if (isset($_SESSION['shopping_cart'])):
              if (count($_SESSION['shopping_cart']) > 0):
            ?>
            <div id="smart-button-container">
              <div style="text-align: center;">
                <div id="paypal-button-container"></div>
              </div>
            </div>
          <script src="https://www.paypal.com/sdk/js?client-id=AQvONVsv7S3NpMyRZXYS0QYr4Vff10YeXTmHT4U5-YtRoNCtbhg2gGKuIqGFXHDXugvX-qL0Ih25rgTh&enable-funding=venmo&currency=EUR" 
          data-sdk-integration-source="button-factory"></script>
          <script>
            function initPayPalButton() {
              paypal.Buttons({
                style: {
                  shape: 'pill',
                  color: 'blue',
                  layout: 'horizontal',
                  label: 'paypal',
                  
                },
        
                createOrder: function(data, actions) {
                  return actions.order.create({
                    purchase_units: [{"description":"Orb of Alteration","amount":{"currency_code":"EUR","value":5.96}}]
                  });
                },
        
                onApprove: function(data, actions) {
                  return actions.order.capture().then(function(orderData) {
                    
                    // Full available details
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
        
                    // Show a success message within this page, e.g.
                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thank you for your payment!</h3>';
        
                    // Or go to another URL:  actions.redirect('thank_you.html');
                    
                  });
                },
        
                onError: function(err) {
                  console.log(err);
                }
              }).render('#paypal-button-container');
            }
            initPayPalButton();
          </script>
            <?php endif; endif; ?>
          </td>
        </tr>
        <?php
        endif;
        ?>

      </div>
    </div>