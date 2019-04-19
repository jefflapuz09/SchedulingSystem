@extends('layouts.admin')
@section('main-content')
<section class="content-header">
      <h1><i class="fa fa-bullhorn"></i>  
        Dashboard
    <!-- Main content -->
    <div>
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          
          <!-- /.info-box -->
        </div>
      </ol>
<!-- image -->      
    <div class='col-sm-8'>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <!--<li class="active"><a href="#tab_1" data-toggle="tab">Enrollment Schedule</a></li>-->
              <li class="active"><a href="#tab_2" data-toggle="tab">About GRC</a></li>
              <!--<li><a href="#tab_3" data-toggle="tab"><label class='label label-info'></label> Annoucement</a></li>-->
            </ul>
            <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="http://scheduling.local/images/grc1.jpg" alt="First slide">

                      <div class="carousel-caption">

                      </div>
                    </div>
                    <div class="item">
                      <img src="http://scheduling.local/images/madex.jpg" alt="Second slide">

                      <div class="carousel-caption">
                        
                      </div>
                    </div>
                  </div>
                  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="fa fa-angle-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="fa fa-angle-right"></span>
                  </a>
                </div>
              
              <div class="tab-pane active" id="tab_2">
                <h3>Mission</h3>
                  <blockquote>
                    <p class="lead">"GRC is creating a culture for successful, socially responsible, morally upright-skilled workers and hightly competent professionals through values based quality education."</p>
                </p><br><br>
                <h3>Vision</h3>
                  <blockquote>
                    <p class="lead">"A global community of excellent individuals with values."</p>
                    
                  </blockquote>
              </div>
</section>
<br><br        
<!--<img style="float: left; margin: 0px 0px 15px 15px;" src="/support/image/your-image.png" width="100" />
<img style="float: left; margin: 0px 0px 15px 15px;" src="/support/image/your-image.png" width="100" />
<img style="float: left; margin: 0px 0px 15px 15px;" src="/support/image/your-image.png" width="100" />
--> 
@endsection
