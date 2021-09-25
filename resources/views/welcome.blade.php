@extends('app')
@section('content')
@if(Session::get('success'))
    <script>swal("Great Job","{!!session::get('success')!!}","success",{
            button:"Done",})
    </script>
@endif
<div class="container-fluid">
    <div class="container">
    <div class="content">
        <div class="aside">
        <header>
        <h5 class="p-3 mb-3 mt-3 text-uppercase">Student Managment System</h5>
    </header>
            <div class="card pl-3 mb-4" style="background-color:#efe7e5">
                <h5 class="p-4 pb-2">Student Registration Form</h5>
                <div class="card-body">
                    
                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                    <input type="text" placeholder="Student Name" class="form-controls" name="student_name" id="student_name" onkeyup="nameValidate()">
                    <span class="text-danger error" id="lblErrorname">@error('studentName'){{$message }} @enderror</span>
                    <div class="form-group">
                    <select class="form-controls" id="standard" name="standard">
                        <option value="class" selected>class</option>
                        <option value="1">i</option>
                        <option value="2">ii</option>
                        <option value="3">iii</option>
                        <option value="4">iv</option>
                        <option value="5">v</option>
                        <option value="6">vi</option>
                        <option value="7">vii</option>
                        <option value="8">viii</option>
                        <option value="9">ix</option>
                        <option value="10">x</option>
                        <option value="11">xi</option>
                        <option value="12">xii</option>
                    </select>
                    <select class="form-controls" id="division" name="division">
                        <option value="Division" selected>Division</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <span class="text-danger error" id="lblErrorstandard">@error('standard'){{$message }} @enderror</span>
                    <span class="text-danger error" id="lblErrordivision">@error('division'){{$message }} @enderror</span>
                    </div>
                    <div class="form-group ">
                        <input type="text" placeholder="Date of Birth" class="form-controls" name="dob" id="dob" onfocus="(this.type='date')">
                        <div class="gender-group">
                            <input type="radio" name="gender" id="gender" value="Male" class="gender p-2">&nbsp;&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="gender" id="gender" class="gender" value="Female" checked>&nbsp;&nbsp;Female
                        </div>
                    </div> 
                    <div class="form-group">
                    <span class="text-danger error" id="lblErrordob">@error('dob'){{$message }} @enderror</span>
                    <span class="text-danger error" id="lblErrorgender">@error('gender'){{$message }} @enderror</span>
                    </div>
                   <button class="button btn-blue" type="submit" id="save" onclick="validate()">Submit</button>
                </div>
            </div>
        </div>
        <div class="section p-5 pt-4">
            <!-- <h5 class="mb-3">Student List</h5> -->
            <table id="dataTable" class="table">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>ID&nbsp;<i class="fas fa-sort"></i></th>
                          <th>Name&nbsp; <i class="fas fa-sort"></i></th>
                          <th>Class&nbsp; <i class="fas fa-sort"></i></th>
                          <th>Division </th>
                          <th>Date of Birth</th>
                          <th>Gender</th>
                          <th>Action</th>
                        </tr>
                  </thead>
                  <tbody><tr></tr></tbody>
           </table>
    </div>
    </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    function validate(){
        let studentName = document.getElementById('student_name').value;
        let standard = document.getElementById('standard').value
        let division = document.getElementById('division').value;
        let dob = document.getElementById('dob').value;
        let lblError = document.getElementById("lblErrorname");  
        let lblErrorstandard = document.getElementById("lblErrorstandard");  
        let lblErrordob = document.getElementById("lblErrordob");  
         
        if(studentName == ''){
            lblError.innerHTML = "Please enter name";
        }
        if(standard == 'class'){
            lblErrorstandard.innerHTML="select class"
        }
        if(division == 'Division'){
            lblErrordivision.innerHTML="select Division"
        }
        if(dob == ''){
            lblErrordob.innerHTML = "Please enter DOB";
    }}
 function nameValidate(){
     let studentName = document.getElementById('student_name').value;
     let lblError = document.getElementById("lblErrorname");
    lblError.innerHTML = "";
    let expr =/^[a-zA-Z ]+$/;
    if(!expr.test(studentName)){
        lblError.innerHTML = "Invalid Name";
    }
 }
</script>
<script>
    $(document).ready(function(){
     var table=$('#dataTable').DataTable({
          ajax:"{{url('read')}}",
        pageLength : 7,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
        "targets": 0,
        columns:[
            { "data": null,"sortable": false, 
                render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }  
            },
            {"data":"student_id"},
            {"data":"student_name"},
            {"data":"standard"},
            {"data":"division"},
            {"data":"dob"},
            {"data":"gender"},
            { 
              "data": null,
              render: function(data, type, row) {
              return `<button data-id="${row.id}" style="text-align: right;" class="btn btn-sm text-danger" id="delete"><i class="fas fa-trash"></i></button>`;
              }
          },
        ]
        
    });
    jQuery('#save').click(function(e){
            e.preventDefault();
            var student_name = jQuery('#student_name').val()
            var standard = jQuery('#standard').val()
            var division = jQuery('#division').val()
            var gender = jQuery("input:radio[name=gender]:checked").val()
            var dob = jQuery('#dob').val()
            jQuery.ajax({
                url:"{{url('create')}}",
                method:"post",
                data: {
                    _token: $("#csrf").val(),
                    student_name:student_name,
                    standard:standard,
                    division:division,
                    dob:dob,
                    gender:gender
                },
                success: function(response) {
                  table.ajax.reload();
                  jQuery('#student_name').val('');
                  jQuery("standard").val('');
                swal("Added","{!!session::get('message')!!}","success",{
                button:"Done",
            })
          } 

            })
        })
        $(document).on('click', '#delete', function() {
        if(confirm('Are you sure you want delete?')){
        $.ajax({
          url: "{{ url('delete') }}",
          type: "post",
          dataType: 'json',
          data: {
              "_token": "{{ csrf_token() }}",
              "id": $(this).attr('data-id')
          },
          success: function(response) {
              table.ajax.reload();
          swal("Deleted","{!!session::get('message')!!}","success",{
          button:"Done",
    })

          }
      })
  }
})
    });
</script>
@endsection