@extends('adminpaneal.authauthor.layout')

@section('content')

 
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
          <h1 class="mb-0"><b>connect</b>U</h1>
        </a>
      </div>


      <!-- /.register-logo -->
      <div class="card">
        <div class="card-body register-card-body">
          <p class="register-box-msg">Register a new Author</p>

          <form id="addform" enctype="multipart/form-data">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
            </div>

            <!-- Email -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" id="email" class="form-control" placeholder="Email">
            </div>

            <!-- Password -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>

            <!-- Confirm Password -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                placeholder="Confirm Password">
            </div>

            <!-- Profile Image -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-file-image"></i></span>
              <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
            <div class="error-message text-danger" id="error-message"></div>
            <div class="text-success fs-6" id="success-message"></div>






            <!--begin::Row-->
            <div class="row">

              <!-- /.col -->
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->


            <!-- /.social-auth-links -->
            <p class="mt-2">
              <a href="{{route('openautherlogin')}}" class="text-center"> I already have a registration </a>
            </p>
          </form>
        </div>
        <!-- /.register-card-body -->
      </div>
      <div>
      </div>
@endsection
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>


    <script>
      $(document).ready(function () {


        $('#addform').on('submit', function (e) {
          e.preventDefault();

          let formData = new FormData();
          formData.append("name", $("#name").val());
          formData.append("email", $("#email").val());
          formData.append("password", $("#password").val());
          formData.append("password_confirmation", $("#password_confirmation").val());
          formData.append("image", $("#image")[0].files[0]); // actual file
          $('#success-message').text('');

          $.ajax({
            url: '/api/register',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              $('#success-message').text(response.message);
              $('#addform')[0].reset(); // Clear the form
              setTimeout(function () {
                $('#success-message').text('');
                $('#success-message').slideUp();

                window.location.href = "/openautherlogin"
              }, 5000);

            },
            error: function (xhr) {
              let errorHtml = '';

              if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                errorHtml = '<ul>';
                errors.forEach(error => {
                  errorHtml += `<li>${error}</li>`;
                });
                errorHtml += '</ul>';
              } else {
                errorHtml = 'Something went wrong. Please try again.';
              }

              // Show error message
              $('#error-message').html(errorHtml).slideDown();

              // Hide after 3 seconds

            }
          })

        });
      });






    </script>