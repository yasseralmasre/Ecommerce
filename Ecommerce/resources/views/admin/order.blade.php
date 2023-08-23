<!DOCTYPE html>
<html lang="en">
  <head>
  @include('admin.css')

<style type="text/css">

    .title_deg
    {

        text-align:center;
        font-size:25px;
        font-weight:bold;
        padding-bottom: 40px;

    }

    .table_deg
    {

        border:2px solid white;
        width: 70%;
        margin:auto;
        text-align :center;
    }
    
    .th_deg
    {
        background-color: skyblue;
    }
    .img_size
    {
        width:200px;
        height:100px;
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
        
        <h1 class="title_deg">All Orders</h1>

        <div style="padding-left:400px; padding-bottom:30px;" >

        <form action="{{url('search')}}" method="get"> 

        @csrf

        <input style="color:black;" type="text" name="search" placeholder="Search for Something">

        <input type="submit" value="Search" class="btn btn-outline-primary">

        </form>

        </div>

        <table class="table_deg">

            <tr class="th_deg">
            
                <th style="padding:10px">Name</th>
                <th style="padding:10px">Email</th>
                <th style="padding:10px">Addess</th>
                <th style="padding:10px">Phone</th>
                <th style="padding:10px">Product_title</th>
                <th style="padding:10px">Quantity</th>
                <th style="padding:10px">Price</th>
                <th style="padding:10px">Payment_Status</th>
                <th style="padding:10px">Delivery_Status</th>
                <th style="padding:10px">Image</th>
                <th style="padding:10px"> Delivered</th>
                <th style="padding:10px"> Print PDF</th>
                <th style="padding:10px"> Email</th>
        
                @forelse($order as $order)
            <tr>

                <td>{{$order->name}}</td>
                <td>{{$order->email}}</td>
                <td>{{$order->address}}</td>
                <td>{{$order->phone}}</td>
                <td>{{$order->product_title}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->price}}</td>
                <td>{{$order->payment_status}}</td>
                <td>{{$order->delivery_status}}</td>
                
                <td>
                    <a href="{{url ('print_pdf' , $order->id)}}" class="btn btn-secondary" >Print PDF</a>
                </td>

                <td>
                    <img class="img_size" src="/product/{{$order->image}}">      
                </td>

                <td> 
                    @if($order->delivery_status == 'processing')
                    <a href="{{url('delivered', $order->id)}}"  class="btn btn-primary"
                    onclick="return confirm('Are You Sure This Product Is Delivered !!!')"> Delivered</a>
                
                    @else

                    <p style="color:green;">Delivered</p>

                    @endif
                </td>

                <td>
                    <a href="{{url ('send_email', $order->id)  }}"  class="btn btn-info">Send Email</a>
                </td>
                

            </tr>


            @empty

            <div>
                <p>No Data Found</p>
            </div>

            @endforelse
            
            
            </tr>

        </table>
        
        </div>
        </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
  </body>
</html>