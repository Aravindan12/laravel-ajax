@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-11">
                <h2>Laravel 7 Ajax CRUD Example</h2>
        </div>
        <div class="col-lg-1">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addModal">Add</a>
        </div>
    </div>
    
    
    <table class="table table-bordered" id="studentTable">
		<thead>
			<tr>
				<th>id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Address</th>
				<th width="280px">Action</th>
			</tr>
		</thead>	
		<tbody>
            @foreach ($students as $student)
                <tr id="{{ $student->id }}">
                <td>{{ $student->id }}</td>
                <td>{{ $student->first_name }}</td>
                <td>{{ $student->last_name }}</td>
                <td>{{ $student->address }}</td>
                <td>
		     <a data-id="{{ $student->id }}" class="btn btn-primary btnEdit">Edit</a>
		     <a data-id="{{ $student->id }}" class="btn btn-danger btnDelete">Delete</button>
                </td>
            </tr>
            @endforeach

		</tbody>
    </table>
	

<!-- Add Student Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Student Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Student</h4>
        </div>
        <div class="modal-body">
          <form id="addStudent" name="addStudent" action="{{ route('student.store') }}" method="post">
              @csrf
              <div class="form-group">
                  <label for="txtFirstName">First Name:</label>
                  <input type="text" class="form-control" id="txtFirstName" placeholder="Enter First Name" name="txtFirstName">
              </div>
              <div class="form-group">
                  <label for="txtLastName">Last Name:</label>
                  <input type="text" class="form-control" id="txtLastName" placeholder="Enter Last Name" name="txtLastName">
              </div>
              <div class="form-group">
                  <label for="txtAddress">Address:</label>
                  <textarea class="form-control" id="txtAddress" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  
<script>
    $(document).ready(function () {
	//Add the Student  
    $("#addStudent").submit(function(e){
    e.preventDefault();
  });
	$("#addStudent").validate({
		 rules: {
				txtFirstName: "required",
				txtLastName: "required",
				txtAddress: "required"
			},
			
 
		 submitHandler: function(form) {
		  var form_action = $("#addStudent").attr("action");
		  $.ajax({
			  data: $('#addStudent').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
				  var student = '<tr id="'+data.id+'">';
				  student += '<td>' + data.id + '</td>';
				  student += '<td>' + data.first_name + '</td>';
				  student += '<td>' + data.last_name + '</td>';
				  student += '<td>' + data.address + '</td>';
				  student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
				  student += '</tr>';            
				  $('#studentTable tbody').prepend(student);
				  $('#addStudent')[0].reset();
				  $('#addModal').modal('hide');
			  },
			  
		  });
		}
	});
});
</script>
