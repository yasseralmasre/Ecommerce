<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />
   </head>
   <body>
      <div class="hero_area">
         
        <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->

         <!-- slider section -->
         @include('home.slider')
         <!-- end slider section -->

      </div>

      <!-- why section -->
      @include('home.why')
      <!-- end why section -->
      
      <!-- arrival section -->
      @include('home.arrival')
      <!-- end arrival section -->
      
      <!-- product section -->
      @include('home.product')
      <!-- end product section -->

      <!--comments and replay-->
      <div style="text-align:center; padding-bottom:30px;">
         
         <h1 style="font-size: 30px; text-align:center;
         padding-top:20px; padding-bottom:20px;">Comments</h1>

         <form action="{{url('add_comment')}}" method="POSt">

            @csrf

            <textarea style="height: 150px; width: 600px;" placeholder="Comment something here" name="comment" ></textarea>

            <br>
         
            <input type="submit" value="Comment" class="btn btn-primary">

         </form>

      </div>

      <div style="padding-left:20%;">

      <h1 style="font-size: 20px; padding-bottom:20px;">All Comments</h1>

        @foreach($comment as $comment)

         <div>

            <b> {{$comment->name}} </b>
            <p> {{$comment->comment}} </p>

            <a style="color:blue;" href="javascript::void(0); " onclick="replay(this)" 
            data-Commentid="{{$comment->id}}" >Reply</a>

            @foreach($replay as $rep)

            @if($rep->comment_id==$comment->id)

            <div style="padding-left:3%; padding-bottom:10px; ">
         

               <b> {{$rep->name}} </b>
               <p> {{$rep->replay}} </p>

               <a style="color:blue;" href="javascript::void(0); " onclick="replay(this)" 
            data-Commentid="{{$comment->id}}" >Reply</a>

            </div>

            @endif

            @endforeach

         </div>

         @endforeach

         <div style="display: none;" class="replayDiv">

         <form action="{{url('add_replay')}}" method="POST">

         @csrf

         <input type="text" id="commentId" name="commentId" hidden=""> 

         <textarea style="height:100px; width:500px;" placeholder="write something here" name="replay"></textarea>

         <br>

         <button type="submit" class="btn btn-warning">Replay</button>

         <a href="javascript::void(0);" class="btn" onClick="replay_close(this)">Close</a>

         </form>
         </div>

      </div>


      <!--end comments and replay-->

      <!-- subscribe section -->
      @include('home.subscribe')
      <!-- end subscribe section -->

      <!-- client section -->
      @include('home.client')
      <!-- end client section -->

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>

      <script type="text/javascript">

         function replay(caller)
         {

            document.getElementById('commentId').value=$(caller).attr('data-Commentid');

            $('.replayDiv').insertAfter($(caller));

            $('.replayDiv').show(); 

   

         }

         function replay_close(caller)
         {

            $('.replayDiv').hide(); 

         }

      </script>

      <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

      <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>