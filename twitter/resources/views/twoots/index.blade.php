@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2>Home</h2>
        </div>
        <div class="container col-6">
        <!--CREATE TWOOT SECTION-->
            <!--<a class="btn btn-success" href="{{ route('twoots.create') }}"> Create New Twoot</a>-->
            @if ($errors->any())
            <div class="alert alert-danger container col-6">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if ($message = Session::get('success'))
            <div class="alert alert-success container col-6">
                <p>{{ $message }}</p>
            </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger container col-6">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <form action="{{ route('twoots.store') }}" method="POST" class="col-6 container">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Post a twoot:</strong>
                            <input type="text" name="content" class="form-control" placeholder="Content">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        <!--CREATE TWOOT SECTION-->
        </div>
    </div>
</div>
    <div class="container col-6 border-top border-left border-right border-primary">
        @foreach ($twoots as $twoot)
        <div class="row border-primary border-bottom">
            <div class="col-2">
                <img src="https://i.pinimg.com/474x/ec/8a/78/ec8a788c83ad5a6bac2d115a274d8917.jpg" alt="profpic" style="border-radius: 100%; width: 100%;" class="img-responsive">
            </div>
            <div class="col-8" style="padding-top: 10px">
                @foreach ($users as $user)
                    @if ($user->id == $twoot->owner_fk)
                        <p><span>@</span>{{ $user->name }}</p>
                    @endif
                @endforeach 
                <p>{{ $twoot->content }}</p>
            </div>
            <div class="col-2">
                <form action="{{ route('twoots.destroy',$twoot->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    @if (auth()->user() != null &&auth()->user()->id == $twoot->owner_fk)
                        <button type="submit" class="btn btn-danger">Delete</button>
                    @endif
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endsection
