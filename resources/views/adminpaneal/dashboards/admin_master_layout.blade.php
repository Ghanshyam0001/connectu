<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AdminLTE v4 | Dashboard</title>
  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
  <!--end::Accessibility Meta Tags-->
  <!--begin::Primary Meta Tags-->
  <meta name="title" content="AdminLTE v4 | Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description"
    content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
  <meta name="keywords"
    content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
  <!--end::Primary Meta Tags-->
  <!--begin::Accessibility Features-->
  <!-- Skip links will be dynamically added by accessibility.js -->
  <meta name="supported-color-schemes" content="light dark" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preload" href={{ asset('admin/dist/css/adminlte.css') }} as="style" />
  <!--end::Accessibility Features-->
  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
    onload="this.media='all'" />
  <!--end::Fonts-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--end::Third Party Plugin(Bootstrap Icons)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href={{ asset('admin/dist/./css/adminlte.css') }} />
  <link rel="stylesheet" href={{ asset('admin/dist/./css/table.css') }} />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!--end::Required Plugin(AdminLTE)-->
  <!-- apexcharts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
  <!-- jsvectormap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
    integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  {{--start Wrapper-- --}}
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left side: sidebar toggle -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
        </ul>

        <!-- Right side: author name + logout button -->
        <div class="d-flex align-items-center gap-2">
          <h3 class="mb-0">Hi {{ Auth::guard('author')->user()?->name ?? 'Guest' }}</h3>
          <div class="me-3">
            <a href="{{ route('author.authorprofile') }}">
              <img id="profile-image"
                src="{{ Auth::guard('author')->user()?->image ? asset('uploads/' . Auth::guard('author')->user()?->image) : asset('uploads/default.png') }}"
                alt="Profile Image" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
            </a>

          </div>
          <button type="button" id="logoutBtn" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>

        </div>
      </div>


    </nav>
    {{-- end Wrapper-- --}}

    {{-- start side menu --}}
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
          <!--begin::Brand Image-->

          <img src="{{ asset('site/news-logo.png') }}" alt="Logo" class="img-fluid  rounded-circle me-2"
            style="height:40px; max-height:50px;">
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">connectU</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
            aria-label="Main navigation" data-accordion="false" id="navigation">
            <li class="nav-item">
              <a href="{{ route('dashboard') }}"
                class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-primary text-white' : '' }}">

                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('author.authorprofile') }}"
                class="nav-link {{ request()->routeIs('author.authorprofile') ? 'active bg-primary text-white' : '' }}">

                <p>Profile</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('types') }}"
                class="nav-link {{ request()->routeIs('types') ? 'active bg-primary text-white' : '' }}">
                <p>Content Type</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="{{ route('categorytypes') }}"
                class="nav-link {{ request()->routeIs('categorytypes') ? 'active bg-primary text-white' : '' }}">

                <p>Category Type</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('allcontent') }}"
                class="nav-link {{ request()->routeIs('allcontent') ? 'active bg-primary text-white' : '' }}">

                <p>Content</p>
              </a>
            </li>





            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon bi bi-box-seam-fill"></i>
                <p>Author Information</p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('author.request') }}"
                    class="nav-link {{ request()->routeIs('author.request') ? 'active bg-primary text-white' : '' }}">

                    <p>Author Request</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('author.active') }}"
                    class="nav-link {{ request()->routeIs('author.active') ? 'active bg-primary text-white' : '' }}">

                    <p>Active Author</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('author.diactive') }}"
                    class="nav-link {{ request()->routeIs('author.diactive') ? 'active bg-primary text-white' : '' }}">

                    <p>Diactive Author</p>
                  </a>
                </li>
              </ul>
            </li>




          </ul>

        </nav>
      </div>

    </aside>
    {{-- end sidemenu --}}


    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->

        <div class="container-fluid">
          <!--begin::Row-->




          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">@yield('title')</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="@yield('link')">@yield('linkname')</a></li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>

      {{-- main --}}
      @yield('contant')




    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline">Admin Panel of connectU</div>
      <!--end::To the end-->
      <!--begin::Copyright-->
      <strong>
        Copyright &copy; 2014-2025&nbsp;
        <a href="#" class="text-decoration-none">connectU</a>.
      </strong>
      All rights reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
 

  <script src={{ asset('admin/dist/js/adminlte.js') }}></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function () {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>

 

  <!--end::OverlayScrollbars Configure-->
  <!-- OPTIONAL SCRIPTS -->
  <!-- sortablejs -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
  <!-- sortablejs -->
  <script>
    new Sortable(document.querySelector('.connectedSortable'), {
      group: 'shared',
      handle: '.card-header',
    });

    const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
    cardHeaders.forEach((cardHeader) => {
      cardHeader.style.cursor = 'move';
    });
  </script>
  <!-- apexcharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
  <!-- ChartJS -->
  <script>
    // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
    // IT'S ALL JUST JUNK FOR DEMO
    // ++++++++++++++++++++++++++++++++++++++++++

    const sales_chart_options = {
      series: [
        {
          name: 'Digital Goods',
          data: [28, 48, 40, 19, 86, 27, 90],
        },
        {
          name: 'Electronics',
          data: [65, 59, 80, 81, 56, 55, 40],
        },
      ],
      chart: {
        height: 300,
        type: 'area',
        toolbar: {
          show: false,
        },
      },
      legend: {
        show: false,
      },
      colors: ['#0d6efd', '#20c997'],
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'smooth',
      },
      xaxis: {
        type: 'datetime',
        categories: [
          '2023-01-01',
          '2023-02-01',
          '2023-03-01',
          '2023-04-01',
          '2023-05-01',
          '2023-06-01',
          '2023-07-01',
        ],
      },
      tooltip: {
        x: {
          format: 'MMMM yyyy',
        },
      },
    };

    const sales_chart = new ApexCharts(
      document.querySelector('#revenue-chart'),
      sales_chart_options,
    );
    sales_chart.render();
  </script>
  <!-- jsvectormap -->
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
    integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
    integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
  <!-- jsvectormap -->
  <script>
    // World map by jsVectorMap
    new jsVectorMap({
      selector: '#world-map',
      map: 'world',
    });

    // Sparkline charts
    const option_sparkline1 = {
      series: [
        {
          data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
        },
      ],
      chart: {
        type: 'area',
        height: 50,
        sparkline: {
          enabled: true,
        },
      },
      stroke: {
        curve: 'straight',
      },
      fill: {
        opacity: 0.3,
      },
      yaxis: {
        min: 0,
      },
      colors: ['#DCE6EC'],
    };

    const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
    sparkline1.render();

    const option_sparkline2 = {
      series: [
        {
          data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
        },
      ],
      chart: {
        type: 'area',
        height: 50,
        sparkline: {
          enabled: true,
        },
      },
      stroke: {
        curve: 'straight',
      },
      fill: {
        opacity: 0.3,
      },
      yaxis: {
        min: 0,
      },
      colors: ['#DCE6EC'],
    };

    const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
    sparkline2.render();

    const option_sparkline3 = {
      series: [
        {
          data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
        },
      ],
      chart: {
        type: 'area',
        height: 50,
        sparkline: {
          enabled: true,
        },
      },
      stroke: {
        curve: 'straight',
      },
      fill: {
        opacity: 0.3,
      },
      yaxis: {
        min: 0,
      },
      colors: ['#DCE6EC'],
    };

    const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
    sparkline3.render();
  </script>
  <!--end::Script-->

  {{-- logout ajax --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <script>

    $(document).ready(function () {
      $('#logoutBtn').on('click', function (e) {
        e.preventDefault();

        // Get the CSRF token from the meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          url: 'api/logout',
          type: 'POST',
          headers: {
            // Pass the CSRF token in the header
            'X-CSRF-TOKEN': csrfToken
          },
          contentType: 'application/json',
          success: function (response) {
            console.log(response.message);
            window.location.href = '/openautherlogin';
          },
          error: function (xhr, status, error) {

            console.error('Logout failed:', xhr.responseText);
            alert('Logout failed. Please try again.');
          }
        });
      });
    });
  </script>

  @yield('script')

</body>
<!--end::Body-->

</html>