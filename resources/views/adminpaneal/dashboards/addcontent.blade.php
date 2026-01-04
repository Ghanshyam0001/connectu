@extends('adminpaneal.dashboards.admin_master_layout')
@section('title')
  Add New Content
@endsection

@section('link')
  /content
@endsection

@section('linkname')
  content
@endsection


@section('contant')
  <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Add New Content</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form id="addContentForm" enctype="multipart/form-data">


                <!-- Title -->
                <div class="mb-3">
                  <label class="form-label">Title</label>
                  <input type="text" name="title" class="form-control">
                </div>

                <!-- Description -->
                <div class="mb-3">
                  <label for="summernote1" class="form-label">Description</label>
                  <textarea id="summernote1" name="description"></textarea> <!-- lowercase -->
                </div>

            

                <!-- Author -->
                <div class="mb-3">
                  <label class="form-label">Author</label>
                  <input type="hidden" name="author_id" value="{{ Auth::guard('author')->user()->id }}">
                  <input type="text" class="form-control" value="{{ Auth::guard('author')->user()->name }}" readonly>
                </div>


                <!-- Category -->
                <div class="mb-3">
                  <label class="form-label">Category</label>
                  <select name="category_id" class="form-control">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                      <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                  </select>
                </div>


                <!-- Content Type -->
                <div class="mb-3">
                  <label class="form-label">Content Type</label>
                  <select name="type_id" id="contentType" class="form-control">
                    <option value="">-- Select Type --</option>
                    @foreach($contentTypes as $ct)
                      <option value="{{ $ct->id }}">{{ ucfirst($ct->name) }}</option>
                    @endforeach
                  </select>
                </div>

                    <!-- Image (for Post) -->
                <div class="mb-3" id="imageField" style="display:none;">
                  <label class="form-label">Upload Image</label>
                  <input type="file" name="image" class="form-control">
                </div>

                <!-- Video (for Video) -->
                <div class="mb-3" id="videoField" style="display:none;">
                  <label class="form-label">Upload Video</label>
                  <input type="file" name="video" class="form-control">
                </div>




                <div class="error-message text-danger" id="error-message"></div>
                <div class="text-success fs-6" id="success-message"></div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary">Add Content</button>
              </form>

            </div>
            <!-- /.card-body -->

          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

  <!-- Bootstrap 5 (if not already in your layout) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Summernote (Bootstrap 5 version) -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#summernote1').summernote({
        placeholder: 'Write your content here...',
        tabsize: 2,
        height: 250,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });

    // Show/hide fields based on content type
    document.getElementById('contentType').addEventListener('change', function () {
      let selectedText = this.options[this.selectedIndex].text.toLowerCase();
      document.getElementById('imageField').style.display = (selectedText === 'post') ? 'block' : 'none';
      document.getElementById('videoField').style.display = (selectedText === 'video') ? 'block' : 'none';
    });

    // Submit form via fetch
    $('#addContentForm').on('submit', function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        url: "{{ url('/api/addnewcontent') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function (data) {

          $('#success-message').text(data.message);
          $('#addContentForm')[0].reset();
          $('#summernote1').summernote('reset'); // clear editor
          $('#imageField').hide();
          $('#videoField').hide();
          setTimeout(function () {
            $('#success-message').text('');
            $('#success-message').slideUp();

            window.location.href = "/allcontent"
          }, 5000);

        },
        error: function (xhr) {
          let errorHtml = '';

          if (xhr.responseJSON && xhr.responseJSON.errors) {
            let errors = xhr.responseJSON.errors;
            errorHtml = '<ul>';
            Object.values(errors).forEach(errorArray => {
              errorArray.forEach(err => {
                errorHtml += `<li>${err}</li>`;
              });
            });
            errorHtml += '</ul>';
          } else if (xhr.responseJSON && xhr.responseJSON.message) {
            errorHtml = xhr.responseJSON.message;
          } else {
            errorHtml = 'Something went wrong. Please try again.';
          }

          $('#error-message').html(errorHtml).slideDown();
        }
      })
    });

  </script>
@endsection