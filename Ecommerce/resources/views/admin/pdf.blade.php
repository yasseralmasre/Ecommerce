<html>

<head>
   
</head>

<body>

    <h1> Order Details </h1>

    Customre Name :     <h3> {{$order->name}} </h3>
    Customre Email :    <h3> {{$order->email}} </h3>
    Customre Phone :    <h3> {{$order->phone}} </h3>
    Customre Address :  <h3> {{$order->address}} </h3>
    Customre ID :       <h3> {{$order->User_id}} </h3>
    
    Product Name :      <h3> {{$order->product_title}} </h3>
    Product Price :     <h3> {{$order->price}} </h3>
    Product Quantity :  <h3> {{$order->quantity}} </h3>
    Payment Status :    <h3> {{$order->payment_status}} </h3>
    Delivery Status :   <h3> {{$order->delivery_status}} </h3>
    Product ID :        <h3> {{$order->product_id}} </h3>
    <br><br>
    <img height="250" width="450" src="product/{{$order->image}}">
    



</body>
</html>