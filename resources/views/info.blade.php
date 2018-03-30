@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Информация пользователя</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Имя: {{ Auth::user()->name }}</p>
                    <p>Почтовый ящик: {{ Auth::user()->email }}</p>
                    <p>Логин: {{ Auth::user()->login }}</p>
                    <p>Пароль: {{ Auth::user()->password }}</p>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
