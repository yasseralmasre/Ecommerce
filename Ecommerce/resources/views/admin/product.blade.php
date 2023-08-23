<!DOCTYPE html>
<html lang="en">
  <head>
  @include('admin.css')

  <style type ="text/css">
  
    .div_center 
    {

        text-align: center;
        padding-top: 40px;

    }

    .font_size
    {

        font-size: 40px;
        padding-bottom: 40px;

    }

    .text_color 
    {
        color: black;
        padding-bottom: 20px;
    }

    label
    {
        display: inline-block;
        width:200px;
    }
    .div_desgin
    {
        padding-bottom:15px;

    }

  </style>

  </head>
  <body>
    <div class="container-scroller">

      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      
       <!-- partial:partials/_navbar.html -->
       @include('admin.header')
        <!-- partial -->

        <div class="main-panel">
            <div class="content-wrapper">

            @if(session()->has('message'))

                <div class="alert alert-success"> 


                <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true" > x </button>

                {{session()->get('message')}}

                </div>
            @endif

            <div class="div_center">

           <h1 class="font_size"> Add product</h1>

        <form action="{{url('/add_product')}}" method="POST" enctype="multipart/form-data">

            @csrf

           <div class="div_desgin" >
           <label>Product Title :</lable>

           <input class="text_color" type="text" name="title" placeholder="Write a title" required="">

            </div>

            <div  class="div_desgin">
           <label>Product Describtion :</lable>

           <input class="text_color" type="text" name="description" placeholder="Write a Describtion" required="">

            </div>

            <div  class="div_desgin">
           <label>Product Price :</lable>

           <input class="text_color" type="number" name="price" placeholder="Write a Price" required="">

            </div>

            <div  class="div_desgin">
            <label>Discount price :</lable>

           <input class="text_color" type="number" name="dis_price" placeholder="Write a Discount is apply">

            </div>

            <div  class="div_desgin">
           <label>Product Quantity :</lable>

           <input class="text_color" type="number"  min="0" name="quantity" placeholder="Write a Quantity" required="">

            </div>

            <div lass="div_desgin" >
           <label>Product Catagorty :</lable>

           <select class="text_color" name="catagory" required="">
            <option value ="" selected="">Add a Catagory here</option>      
            @foreach($catagory as $catagory)
            <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>   
            @endforeach
            </select>

            </div>

            <div class="div_desgin">
           <label>Product Image Here :</lable>

           <input  type="file" name ="image" required="">

            </div>

            <div class="div_desgin">

           <input type="submit" value="Add Product" class="btn btn-primary">

            </div>

            </form>


           
</div>
</div>
</div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
  </body>
</html>