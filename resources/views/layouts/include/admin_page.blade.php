@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <button type="button" class="btn btn-default" onclick="window.location='{{ url("home") }}'">Go back</button>

    </div>
    <div class="col-md-6 text-right">
      <button type="button" class="btn btn-primary" onclick="window.location='{{ url("home/users/add") }}'">Add new user</button>

    </div>
  </div>
  <br>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Dashboard - Users</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Type</th>
                <th>Settings</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)

              <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->type}}</td>
                <td>
                  @if (Auth::user()->email !== $user->email)
                  {{$user->id}}
                  <button type="button" data-toggle="modal" data-id="{{ $user->id }}" data-email="{{ $user->email }}" data-target="#deleteUser" class="btn btn-danger">Remove user</button>
                  <button id="changeType" data-id="{{ $user->id }}" data-type="{{ $user->type }}" type="button" class="btn btn-default" >Change type</button>

                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"id="deleteUserLabel">Are you sure?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          Please confirm that you want to remove user
          <b><span id="user-email"></span></b>
          from database. <span id="user-id" style="display:none">vvvv</span>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" id="removeUser" class="btn btn-default">Remove user</button>
        <span class="pull-right">
          <button type="button" class="btn btn-primary">
            Cancel
          </button>
        </span>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
@yield('script')

<script type="text/javascript">
$(function() {
  var selectedId = -1;
  $('#deleteUser').on("show.bs.modal", function (e) {
     $("#deleteUserLabel").html($(e.relatedTarget).data('email'));
     $("#user-email").html($(e.relatedTarget).data('email'));
     $("#user-id").html($(e.relatedTarget).data('id'));
     selectedId = $(e.relatedTarget).data('id');
  });

  $("#changeType").click(function(e) {
    console.log($(this).attr("data-id"));
    console.log($(this).attr("data-type"));
    var data = $(this).attr("data-type")
    if(data == "worker") {
      data = "admin"
    } else {
      data = "worker"
    }
    $.ajax({
      type: 'POST',
      url: '/home/users/changeType',
      dataType: 'json',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data: {newType:data, id: $(this).attr("data-id"), "_token": "{{ csrf_token() }}"},

      success: function (data) {
        location.reload();
      },
      error: function (data) {
        location.reload();
      }
    });
  });

  $("#removeUser").click(function(e) {
    $.ajax({
      type: 'DELETE',
      url: '/home/users/delete',
      dataType: 'json',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data: {id:selectedId, "_token": "{{ csrf_token() }}"},

      success: function (data) {
        location.reload();
      },
      error: function (data) {
        location.reload();
      }
    });
  });
});
</script>
@endsection
