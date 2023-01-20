@extends('layouts.app')

@section('content')



@role('admin')

<div id="greet" class="container">
    <div class="row">
        <h2>
            Welcome {{Auth::user()->name}},
        </h2>
    </div>
    <h3>You can now approve/reject leaves</h3>
</div>
<br/>

<div class="container">
    <div id="pending-records">
        <h4>Pending Requests</h4>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>User</th>
                    <th>Leave Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach($data[0] as $key => $val)
                <tr>    
                    <td>{{$val->name}}</td>
                    <td>{{$val->holiday_date}}</td>                
                    <td>
                        <button type="button" class="btn btn-danger">Reject</button>&nbsp;
                        <button type="button" class="btn btn-success">Approve</button>
                    </td>                
                </tr>
            @endforeach
        </table>
    </div>

    <br/>
    <br/>
    <br/>

    <div id="all-records">
        <h4>Non pending records</h4>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>User</th>
                    <th>Leave Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            @foreach($data[1] as $key => $val)
                <tr>    
                    <td>{{$val->name}}</td>
                    <td>{{$val->holiday_date}}</td>                
                    <td>{{$val->approval_status}}</td>                
                </tr>
            @endforeach
        </table>
    </div>


</div>

@else

<div id="greet" class="container">
    <div class="row">
        <h2>
            Welcome {{Auth::user()->name}},
        </h2>
    </div>
    <h3>You can now apply your leave</h3>
</div>
<br/>
<div class="container">
    <div class="row">
        <div id="form-apply-leave" class="col">
            <form method="POST" action="/addHoliday">
                @csrf
                <div class="form-group col-md-4">
                    <label for="holiday_date">Apply Leave For:</label>
                    <input type="date" name="holiday_date" class="form-control">
                </div>
                <br/>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br/>
            <br/>
            @if(session('status'))
                <div class="alert alert-success col-md-4">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="col">
            <h4>You have applied for leaves for below mentioned dates</h4>
            @if (count($data) > 0)
            
                <table class="table table-striped table-hover">
                    <caption>Status: 0=Pending, 1=Approved</caption>
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                @foreach($data as $key => $val)
                    <tr>    
                        <td>{{$val->holiday_date}}</td>
                        <td>
                            @if ($val->approval_status == '') pending
                            @else {{$val->approval_status}}
                            @endif
                        </td>                
                    </tr>
                @endforeach
            @else
                <p class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    You haven't applied for any leave yet
                </p>
            @endif
        </div>
    </div>

</div>


@endrole

@endsection