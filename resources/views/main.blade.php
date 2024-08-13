<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('style/assets/img/apple-icon.png')}}">
  <title>
    @yield('title')
  </title>
  {{-- Favicon --}}
  <link rel="icon" type="image/x-icon" href="{{ asset('style/assets/img/Favicon.png') }}">
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('style/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{ asset('style/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('style/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('style/assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
  {{-- Bootstrap Icon --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>


<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>

  {{-- SIDEBAR SECTION --}}
    @include('partials.sidebar')

  <main class="main-content position-relative border-radius-lg ">

    {{-- HEADER SECTION --}}
    @include('partials.header')

      {{-- MAIN SECTION --}}
      @yield('content')
      
    {{-- FOOTER SECTION --}}
    @include('partials.footer')

  </main>
  
  <!--   Core JS Files   -->
  <!-- MQTT Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
  <script src="{{ asset('style/assets/js/core/popper.min.js')}}"></script>
  <script src="{{ asset('style/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('style/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('style/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{ asset('style/assets/js/plugins/chartjs.min.js')}}"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('style/assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
  {{-- Chart JS --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
 
</body>

</html>
