@extends('adminpaneal.dashboards.admin_master_layout')
@section('title')
  Content Types
@endsection

@section('link')
  /dashboard
@endsection

@section('linkname')
  Dashboard
@endsection


@section('contant')

  <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Content Types</h3>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addtype">
                  Add Type
                </button>
              </div>

              <div id="success-message" class="text-success bg-white px-2 py-1 fw-bold mt-2 d-none"
                style="border-radius: 4px;">
              </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">Id</th>
                    <th>Type Name</th>
                    <th>Edit</th>
                    <th>Delete</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $type)
                    <tr>
                      <td>{{$type->id}}</td>
                      <td>{{$type->name}}</td>
                      <td><button class="btn btn-primary btn-sm" data-bs-postid="{{ $type->id }}" data-bs-toggle="modal"
                          data-bs-target="#changetypes">
                          Edit
                        </button></td>
                      <td><button class="btn btn-danger btn-sm delete-btn" data-bs-postid="{{ $type->id }}">Delete</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
            <!-- /.card-body -->

          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- update type --}}

<div class="modal fade" id="changetypes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="typeLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <form id="updatetype">

        <div class="modal-header">
          <h5 class="modal-title fs-5" id="typeLabel">Edit Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="id" name="id" class="form-control" required>

          <div class="mb-3">
            <label for="name" class="form-label"><b>Type Name</b></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Type Name">
          </div>
            <div class="er-message text-danger" id="er-message"></div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Save changes" class="btn btn-primary update-btn">
        </div>

      </form>

    </div>
  </div>
</div>


  {{-- add type --}}

  <div class="modal fade" id="addtype" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addtypeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="addtypeLabel">Add Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="addtyp">
          <div class="modal-body">
            <div class="mb-3">
              <label for="typename" class="form-label"><b>Type Name</b></label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Type Name">
            </div>
            <div class="err-message text-danger" id="err-message"></div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Type</button>
          </div>
        </form>

      </div>
    </div>
  </div>

@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>



  <script>
    $(document).ready(function () {


      $('#addtyp').on('submit', function (e) {
        e.preventDefault();



        const formData = new FormData(this);

        $.ajax({
          url: '/api/addtype',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success: function () {

            window.location.href = "/types";
          },

          error: function (xhr) {
            let errorHtml = '';

            if (xhr.responseJSON && xhr.responseJSON.errors) {

              let errors = xhr.responseJSON.errors;
              console.log(errors);
              errorHtml = '<ul>';


              Object.values(errors).forEach(errorArray => {

                errorArray.forEach(err => {
                  errorHtml += `<li>${err}</li>`;
                });
              });
              errorHtml += '</ul>';

              $('#err-message').html(errorHtml);


            } else if (xhr.responseJSON && xhr.responseJSON.message) {
              errorHtml = xhr.responseJSON.message;
            } else {
              errorHtml = 'Something went wrong. Please try again.';
            }



          }
        });
      });






      $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("bs-postid");

        if (confirm("Are you sure you want to delete this type?")) {
          $.ajax({
            url: `/api/deletetype/${id}`,
            type: 'DELETE',
            data: {
              _token: document.querySelector('meta[name="csrf-token"]').content
            },
            success: function (response) {

              $("#success-message")
                .removeClass("d-none")
                .text(response.message || "Type deleted successfully");


              $("#row-" + id).remove();


              setTimeout(() => location.reload(), 1500);
            },
            error: function (xhr) {
              alert("Error deleting type");
              console.error(xhr.responseText);
            }
          });
        }
      });


      // showtype in model
      const updatetypemodel = document.querySelector("#changetypes");

      if (updatetypemodel) {
        updatetypemodel.addEventListener('show.bs.modal', event => {
          const button = event.relatedTarget;
          const id = button.getAttribute('data-bs-postid');

          $.ajax({
            url: `/api/changetype/${id}`,
            type: "GET",
            dataType: "json",
            headers: {
              "Accept": "application/json",
            },
            xhrFields: {
              withCredentials: true
            },
            success: function (data) {
              let typedata = data.data;
              document.querySelector("#id").value = typedata.id;
              document.querySelector("#name").value = typedata.name;
            },
            error: function (xhr) {
              let errorHtml = '';

              if (xhr.responseJSON) {
                if (xhr.responseJSON.errors) {

                  // Handle validation errors (object of arrays)
                  let errors = xhr.responseJSON.errors;

                  errorHtml = '<ul>';
                  Object.keys(errors).forEach(function (key) {
                    errors[key].forEach(function (error) {
                      errorHtml += `<li>${error}</li>`;
                    });
                  });
                  errorHtml += '</ul>';
                } else if (xhr.responseJSON.message) {

                  errorHtml = `<p>${xhr.responseJSON.message}</p>`;
                } else {
                  errorHtml = 'Something went wrong. Please try again.';
                }
              } else {
                errorHtml = 'Server error. Please try again.';
              }

              $('#error-message').html(errorHtml).slideDown();
            }

          });
        });
      }

      // Update type
      if ($("#updatetype").length) {
        $("#updatetype").on("submit", function (e) {
          e.preventDefault();

          const id = document.querySelector("#id").value;

          const formData = new FormData(this);

          $.ajax({
            url: `/api/updatetyp/${id}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
              "X-HTTP-Method-Override": "PUT",
              "Accept": "application/json",
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (data) {
              window.location.href = "/types";
            },
            error: function (xhr) {
              let errorHtml = '';

              if (xhr.responseJSON && xhr.responseJSON.errors) {

                let errors = xhr.responseJSON.errors;
                console.log(errors);
                errorHtml = '<ul>';


                Object.values(errors).forEach(errorArray => {

                  errorArray.forEach(err => {
                    errorHtml += `<li>${err}</li>`;
                  });
                });
                errorHtml += '</ul>';

                $('#er-message').html(errorHtml);


              } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorHtml = xhr.responseJSON.message;
              } else {
                errorHtml = 'Something went wrong. Please try again.';
              }



            }
          });
        });
      }



    });



  </script>
@endsection