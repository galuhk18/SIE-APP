@extends('template.base_admin')
@section('title')
<title>{{ env('APP_NAME') }}</title>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Penduduk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $population_amount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Pelayanan Desa
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $service_amount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Keputusan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $decision_amount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Laporan Kelahiran & Kematian
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $birth_death_amount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="card">
    <div class="card-body">
        @if(session()->has('admin_id'))
            <div class="text-center">
                <h1>Selamat Datang</h1>
                <h2>Administrator</h2>
                <p>{{ env('APP_NAME') }}</p>
            </div>
        @endif

        @if(session()->has('executive_id'))
            <div class="text-center">
                <h1>Selamat Datang</h1>
                <h2>Executive</h2>
                <p>{{ env('APP_NAME') }}</p>
            </div>
        @endif
    </div>
</div>

@if (session()->has('executive_id'))    
    <div class="row mt-2">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <canvas id="chart-funding-petition-amount"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <canvas id="chart-funding-petition-budget-amount"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <canvas id="chart-building-rental"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <canvas id="chart-facility-rental"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <canvas id="chart-birth-death"></canvas>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
@if (session()->has('executive_id'))    
@section('script')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script>
    var cData1 = JSON.parse(`<?php echo $chart_funding_petition_amount; ?>`);
    var cData2 = JSON.parse(`<?php echo $chart_funding_petition_budget_amount; ?>`);
    var cData3 = JSON.parse(`<?php echo $chart_birth_death; ?>`);
    var cData4 = JSON.parse(`<?php echo $chart_building_rental; ?>`);
    var cData5 = JSON.parse(`<?php echo $chart_facility_rental; ?>`);
    var ctx1 = $("#chart-funding-petition-amount");
    var ctx2 = $("#chart-funding-petition-budget-amount");
    var ctx3 = $("#chart-birth-death");
    var ctx4 = $("#chart-building-rental");
    var ctx5 = $("#chart-facility-rental");

    var data1 = {
        labels: cData1.label,
        datasets: [{
            label: "Jumlah Permohonan Dana",
            data: cData1.data,

            backgroundColor: [
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14',
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b'
            ],
            borderColor: [
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14',
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b'
            ],
            borderWidth: [1, 1, 1, 1, 1, 1, 1]
        }]
    };

    var data2 = {
        labels: cData2.label,
        datasets: [{
            label: "Jumlah Anggaran Permohonan Dana",
            data: cData2.data,

            backgroundColor: [
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14',
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b'
            ],
            borderColor: [
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14',
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b'
            ],
            borderWidth: [1, 1, 1, 1, 1, 1, 1]
        }]
    };

    var data3 = {
        labels: cData3.label,
        datasets: [{
            label: "Jumlah Kelahiran dan Kematian",
            data: cData3.data,

            backgroundColor: [
                '#f6c23e',
                '#5a5c69'
            ],
            borderColor: [
                '#f6c23e',
                '#5a5c69'
            ],
            borderWidth: [1, 1, 1, 1, 1, 1, 1]
        }]
    };

    var data4 = {
        labels: cData4.label,
        datasets: [{
            label: "Jumlah Penyewaan Gedung",
            data: cData4.data,

            backgroundColor: [
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b',
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14'
                
            ],
            borderColor: [
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b',
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14'
                
            ],
            borderWidth: [1, 1, 1, 1, 1, 1, 1]
        }]
    };

    var data5 = {
        labels: cData5.label,
        datasets: [{
            label: "Jumlah Penyewaan Fasilitas",
            data: cData5.data,

            backgroundColor: [
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b',
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14'
                
            ],
            borderColor: [
                '#f6c23e',
                '#1cc88a',
                '#20c9a6',
                '#36b9cc',
                '#858796',
                '#5a5c69',
                '#091734',
                '#FA9044',
                '#e74a3b',
                '#4e73df',
                '#6610f2',
                '#6f42c1',
                '#e83e8c',
                '#e74a3b',
                '#fd7e14'
                
            ],
            borderWidth: [1, 1, 1, 1, 1, 1, 1]
        }]
    };

    var options1 = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Permohonan Dana {{ $year }}",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        }
    };

    var options2 = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Anggaran Permohonan Dana {{ $year }}",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    return (
                        "Rp " +
                        tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    );
                },
            },
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function (value, index, values) {
                        if (parseInt(value) >= 1000) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                            return 'Rp ' + value;
                        }
                    }
                }
            }]
        }
    };

    var options3 = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Grafik Kelahiran dan Kematian",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        }
    };

    var options4 = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Grafik Penyewaan Gedung",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        }
    };

    var options5 = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Grafik Penyewaan Fasilitas",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        }
    };

    var chart1 = new Chart(ctx1, {
        type: "bar",
        data: data1,
        options: options1
    });

    var chart2 = new Chart(ctx2, {
        type: "bar",
        data: data2,
        options: options2
    });

    var chart3 = new Chart(ctx3, {
        type: "pie",
        data: data3,
        options: options3
    });

    var chart4 = new Chart(ctx4, {
        type: "bar",
        data: data4,
        options: options4
    });

    var chart5 = new Chart(ctx5, {
        type: "bar",
        data: data5,
        options: options5
    });

</script>
@endsection
@endif
