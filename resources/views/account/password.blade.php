<?php 
$layout = "";
if(Auth::user()->accesslevel == 100){
    $layout = 'layouts.superadmin';
}elseif(Auth::user()->accesslevel == 1){
    $layout = 'layouts.first_login';
}elseif(Auth::user()->accesslevel == 0){
    $layout = 'layouts.admin';
}

?>
@extends($layout)

@section('main-content')
<section class="content-header">
    <h1><i class="fa fa-key"></i>  
        Account
        <!-- Main content -->
        
<section class="content">
    <div class='col-sm-4'>
        <div class="box box-solid box-default">
           <div class="box-header with-border">
             <h3 class="box-title">Change Password</h3>
             <div class="box-tools pull-right">
               <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             </div><!-- /.box-tools -->
           </div><!-- /.box-header -->
           <div class="box-body">
               <form action='{{ url('/account/change_pass') }}' method='post'>
                {{csrf_field()}}
               @if (count($errors) > 0)
               <div class="alert alert-danger">
                   <ul>
                       @foreach ($errors->all() as $error)
                       <li>{{ $error }}</li>
                       @endforeach
                   </ul>
               </div>
               @endif
               
               @if(Session::has('success'))
               <div class='callout callout-success'>
                   <div align='center'>{{Session::get('success')}}</div>
               </div>
               @endif
                <input type='hidden' value='{{Auth::user()->id}}' name='idno'>
               <br>
               <div class='form-group'>
                   <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                       <input type="password" class="form-control" name='password' placeholder="Password">
                   </div>
               </div>
               <div class='form-group'>
                   <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-repeat"></i></span>
                       <input type="password" class="form-control"  name='password_confirmation' placeholder="Confirm Password">
                   </div>
               </div>
               <div class='form-group'>
                   <button type="submit" class="btn btn-primary btn-block btn-flat">Change</button>
               </div>
               </form>
           </div><!-- /.box-body -->
         </div><!-- /.box -->
   </div>
</section>
            
@endsection
