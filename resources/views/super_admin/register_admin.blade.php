@extends('layouts.superadmin')
@section('main-content')
<section class="content-header">
    <h1><i class="fa fa-user"></i>  
        Register Admin
        <!-- Main content -->
        
<section class="content">
    <div class="register-box-body col-sm-5 col-sm-offset-3">
    <p class="login-box-msg">Register a New Administrator</p>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger" style='font-size:9pt;'>
            <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (Session::has('success'))
        <div class="callout callout-success">
            <div align='center'>{{Session::get('success')}}</div>
        </div>
    @endif
    
    <form action="{{ url('/superadmin/register_admin/save') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Userame" name="username" value="{{ old('username') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="First Name" name="name" value="{{ old('name') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Middle Name" name="middlename" value="{{ old('middlename') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="{{ old('lastname') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email" value="{{ old('email') }}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.retrypepassword') }}" name="password_confirmation"/>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
            </div><!-- /.col -->
        </div>
    </form>
</div><!-- /.form-box -->
</section>
            
@endsection

 

