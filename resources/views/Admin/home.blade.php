@extends('layouts.master')

@section('content')
<link href="{{ asset('/plugin/tooltip/tooltip-flip.css') }}" rel="stylesheet" type="text/css" />
    <!-- Card stats -->
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Books</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_book'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Authors</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_author'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                <i class="fas fa-user-edit"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Admin Assistant</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_adminassistant'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Colleges</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_college'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total College Admins</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_subadmin'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                <i class="fas fa-user-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Tutors</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_tutor'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                <i class="fas fa-user-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Students</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $data['card']['total_student'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                <i class="fas fa-user-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                            <h2 class="mb-0">Books</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="chart-books" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">User</h6>
                            <h2 class="mb-0">New Users</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="chart-users" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5" id="dashboard_tables">
        <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Latest Books</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('book.index') }}" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive-sm">
                            <!-- Projects table -->
                            <table class="table align-items-center dataTable md-responsive table-responsive">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Sr No</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Book</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data['list']['book'])>0)
                                        @foreach($data['list']['book'] as $index=>$book)
                                            <tr>
                                                <th scope="row">
                                                    {{ $index+1 }}
                                                </th>
                                                <td>
                                                    <a  href="{{ route('author.show',['id'=>$book->author_id,'redirect_url'=>route('home')]) }}"  class="tooltip tooltip-effect-3" ><b>{{ (optional($book->getAuthor)->name) }}</b><span class="tooltip-content"><span class="tooltip-front"><img class="m-inherit mlr-auto mt-6px" src="{{ getSingleMedia($book->getAuthor,'image',null) }}" alt="user3"/></span><span class="tooltip-back"><div>{{ (optional($book->getAuthor)->name) }}</div></span></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{route('book.view',['id'=>$book->book_id,'redirect_url'=>route('home')])}}">{{ optional($book)->name }}</a>
                                                </td>
                                                <td>
                                                    {{ money(optional($book)->price) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th colspan="4" scope="row" class="text-center">
                                                No Records Found.
                                            </th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Lastest Colleges</h3>
                        </div>
                        <div class="col text-right">
                            <a href='{{ route("college.index") }}' class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive-sm">
                            <!-- Projects table -->
                            <table class="table align-items-center dataTable md-responsive table-responsive">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">GPS</th>
                                        <th scope="col">Country</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data['list']['college'])>0)
                                        @foreach($data['list']['college'] as $index=>$college)
                                            <tr>
                                                <th scope="row">
                                                    {{ date('Y-m-d' ,strtotime(optional($college)->created_at)) }}
                                                </th>
                                                <td>
                                                    {{ ucwords(optional($college)->name) }}
                                                </td>
                                                <td>
                                                    {{ ucwords(optional($college)->gps) }}
                                                </td>
                                                <td>
                                                    {{ ucwords(optional($college)->country) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th colspan="4" scope="row" class="text-center">
                                                No Records Found.
                                            </th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body_bottom')
    <script>
        var chart_books = "{{ implode(',',$data['graph']['books']) }}";
        var chart_users = "{{ implode(',',$data['graph']['users']) }}";
        chart_books = chart_books.split(",");
        chart_users = chart_users.split(",");

        $(document).ready(function () {
            //
            // Books chart
            //

            var BooksChart = (function() {

                // Variables

                var $chart = $('#chart-books');


                // Methods

                function init($chart) {

                    var booksChart = new Chart($chart, {
                        type: 'line',
                        options: {
                            scales: {
                                yAxes: [{
                                    gridLines: {
                                        color: Charts.colors.gray[900],
                                        zeroLineColor: Charts.colors.gray[900]
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            if (!(value % 10)) {
                                                return value;
                                            }
                                        }
                                    }
                                }]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(item, data) {
                                        var label = data.datasets[item.datasetIndex].label || '';
                                        var yLabel = item.yLabel;
                                        var content = '';

                                        if (data.datasets.length > 1) {
                                            content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                        }

                                        content += '<span class="popover-body-value">$' + yLabel + '</span>';
                                        return content;
                                    }
                                }
                            }
                        },
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                label: 'Performance',
                                data: chart_books
                            }]
                        }
                    });

                    // Save to jQuery object

                    $chart.data('chart', booksChart);

                };


                // Events

                if ($chart.length) {
                    init($chart);
                }

            })();

            //
            // Orders chart
            //

            var UsersChart = (function() {

                //
                // Variables
                //

                var $chart = $('#chart-users');
                var $usersSelect = $('[name="usersSelect"]');


                //
                // Methods
                //

                // Init chart
                function initChart($chart) {

                    // Create chart
                    var usersChart = new Chart($chart, {
                        type: 'bar',
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        callback: function(value) {
                                            if (!(value % 10)) {
                                                //return '$' + value + 'k'
                                                return value
                                            }
                                        }
                                    }
                                }]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(item, data) {
                                        var label = data.datasets[item.datasetIndex].label || '';
                                        var yLabel = item.yLabel;
                                        var content = '';

                                        if (data.datasets.length > 1) {
                                            content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                        }

                                        content += '<span class="popover-body-value">' + yLabel + '</span>';

                                        return content;
                                    }
                                }
                            }
                        },
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                label: 'Sales',
                                data: chart_users
                            }]
                        }
                    });

                    // Save to jQuery object
                    $chart.data('chart', usersChart);
                }


                // Init chart
                if ($chart.length) {
                    initChart($chart);
                }

            })();

        });
    </script>
@endsection
