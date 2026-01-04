@extends('adminpaneal.authauthor.layout')

@section('content')

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
          <h1 class="mb-0"><b>connect</b>U</h1>
        </a>
      </div>
      <div class="card-body login-card-body">

        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="email" type="email" name="email" class="form-control" />
            <label for="">Email</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="token" type="token" name="token" class="form-control" />
            <label for="">Token</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        <div class="input-group mb-2">
          <div class="form-floating">
            <input type="password" name="password" id="password" class="form-control">
            <label for="">Password</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        <div class="input-group mb-2">
          <div class="form-floating">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            <label for="">Confirmd Password</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        <div id="error-message" class="text-danger"></div>

        <!--begin::Row-->
        <div class="row">

          <!-- /.col -->
          <div class="col-12 mt-3">
            <div class="d-grid gap-2">
              <div class="text-success" id="timer"></div>
              <button id="loginbtn" type="button" class="btn btn-primary w-100">Reset Password</button>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!--end::Row-->



      </div>
      <!-- /.login-card-body -->
    </div>
  </div>


@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

<script>
  $(document).ready(function () {

    const savedEmail = localStorage.getItem('resetemail');

    if (savedEmail) {
      
      $("#email").val(savedEmail);
    }

    let duration = 2 * 60; 
    let display = $('#timer');

    let countdown = setInterval(function () {
      let minutes = Math.floor(duration / 60);
      let seconds = duration % 60;

      // Format 0X
      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.text("Time left: " + minutes + ":" + seconds);

      // Decrease
      duration--;

      // When time ends
      if (duration < 0) {
        clearInterval(countdown);
        display.text("Reset time expired!");
      }
    }, 1000);

    $('#loginbtn').on('click', function (e) {
      e.preventDefault();
      const csrfToken = $('meta[name="csrf-token"]').attr('content');
      const email = savedEmail
      const token = $("#token").val()
      const password = $("#password").val();
      const password_confirmation = $("#password_confirmation").val();


      $.ajax({
        url: 'api/resetauthorpassword',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        contentType: 'application/json',
        data: JSON.stringify({
          email: email,
          token: token,
          password: password,
          password_confirmation, password_confirmation


        }),
        success: function (response) {
          console.log(response);
          localStorage.removeItem('resetemail');


          window.location.href = "/openautherlogin"
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
              // Handle simple message (e.g., invalid credentials)
              errorHtml = `<p>${xhr.responseJSON.message}</p>`;
            } else {
              errorHtml = 'Something went wrong. Please try again.';
            }
          } else {
            errorHtml = 'Server error. Please try again.';
          }

          $('#error-message').html(errorHtml).slideDown();
        }

      })
    })


  })

</script>