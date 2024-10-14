@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5"></div>
</div>

<div class="page-inner mt--5">
    @if (Auth::user()->role == 4)
        <div class="row mt--2">
            <div class="col-12">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Booked List</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive-sm">
                            <table id="tblUser" class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th  class="d-none" scope="col">{{ __('#') }}</th>
                                        <th scope="col">{{ __('Booking Type') }}</th>
                                        <th scope="col">{{ __('# of Adults') }}</th>
                                        <th scope="col">{{ __('# of Children') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col">{{ __('Booking Status') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bookings->count())
                                    @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="d-none">{{ $booking->id }}</td>
                                        <td>{{ $booking->boooking_status }}</td>
                                        <td>{{ $booking->no_of_adults }}</td>
                                        <td>{{ $booking->no_of_children }}</td>
                                        <td>{{ $booking->created_at->format('M d, Y h:i a') }}</td>
                                        <td> 
                                            @if ($booking->status == "cancel")
                                                <span class="badge badge-danger">
                                                    Cancel booking
                                                </span>
                                            @elseif ($booking->status == "booked")
                                                <span class="badge badge-info">
                                                    Booked
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    Approved
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr style=" text-align: center;font-size: large;vertical-align: middle;">
                                        <td colspan="6">{{ __('No Records found.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mt--2">
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Overall statistics</div>
                        <div class="card-category">Daily information about statistics in system</div>
                        <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-1"></div>
                                <h6 class="fw-bold mt-3 mb-0">
                                    <i class="fas fa-angry mr-2" style="color: red;"></i>Angry
                                </h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-2"></div>
                                <h6 class="fw-bold mt-3 mb-0"> <i class="fas fa-sad-tear mr-2" style="color: orange;"></i>
                                    Sad</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-3"></div>
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-meh mr-2" style="color: gray;"></i>Neutral</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-4"></div>
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-smile mr-2" style="color: green;"></i>Smile</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-5"></div>
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-grin-stars mr-2" style="color: gold;"></i>Happy</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Feedback List</div>
                        <div class="card-category">Daily information about statistics in system</div>
                        <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                            <div class="px-2 pb-2 pb-md-0 text-left">
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-list-alt mr-2"></i>Services</h6>
                                <h6 class="fw-bold mt-3 mb-0">Food/Resto</h6>
                                <h6 class="fw-bold mt-3 mb-0">Accommodations</h6>
                                <h6 class="fw-bold mt-3 mb-0">Recreations Activities</h6>
                                <h6 class="fw-bold mt-3 mb-0">Place</h6>
                                <h6 class="fw-bold mt-3 mb-0">Services</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-angry mr-2" style="color: red;"></i>Angry</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="food_resto_angry">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="accomodations_angry">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="recreations_act_angry">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="place_angry">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="services_angry">0</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-sad-tear mr-2" style="color: orange;"></i>Sad</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="food_resto_sad">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="accomodations_sad">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="recreations_act_sad">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="place_sad">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="services_sad">0</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-meh mr-2" style="color: gray;"></i>Neutral</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="food_resto_neutral">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="accomodations_neutral">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="recreations_act_neutral">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="place_neutral">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="services_neutral">0</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-smile mr-2" style="color: green;"></i>Smile</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="food_resto_smile">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="accomodations_smile">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="recreations_act_smile">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="place_smile">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="services_smile">0</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <h6 class="fw-bold mt-3 mb-0"><i class="fas fa-grin-stars mr-2" style="color: gold;"></i>Happy</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="food_resto_happy">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="accomodations_happy">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="recreations_act_happy">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="place_happy">0</h6>
                                <h6 class="fw-bold mt-3 mb-0" id="services_happy">0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 d-none">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Total income & spend statistics</div>
                        <div class="row py-3">
                            <div class="col-md-4 d-flex flex-column justify-content-around">
                                <div>
                                    <h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
                                    <h3 class="fw-bold">$9.782</h3>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-uppercase text-danger op-8">Total Spend</h6>
                                    <h3 class="fw-bold">$1,248</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div id="chart-container">
                                    <canvas id="totalIncomeChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row  d-none">
            <div class="col-md-4">
                <div class="card card-primary bg-primary-gradient">
                    <div class="card-body">
                        <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Active user right now</h4>
                        <h1 class="mb-4 fw-bold">17</h1>
                        <h4 class="mt-3 b-b1 pb-2 mb-5 fw-bold">Page view per minutes</h4>
                        <div id="activeUsersChart"></div>
                        <h4 class="mt-5 pb-3 mb-0 fw-bold">Top active pages</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between pb-1 pt-1"><small>/product/readypro/index.html</small> <span>7</span></li>
                            <li class="d-flex justify-content-between pb-1 pt-1"><small>/product/atlantis/demo.html</small> <span>10</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Daily Sales</div>
                        <div class="card-category">March 25 - April 02</div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-4 mt-2">
                            <h1>$4,578.58</h1>
                        </div>
                        <div class="pull-in">
                            <canvas id="dailySalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right text-warning">+7%</div>
                        <h2 class="mb-2">213</h2>
                        <p class="text-muted">Transactions</p>
                        <div class="pull-in sparkline-fix">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-title">User Feedback Activity</div>
                    </div>
                    <div class="card-body">
                        <ol class="activity-feed" id="feedback-activity-feed">
                            
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Booking Tickets</div>
                            <div class="card-tools">
                                <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-today" data-toggle="pill" href="#pills-today" role="tab">Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-week" data-toggle="pill" href="#pills-week" role="tab">Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab">Month</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="booking-list">
                        <!-- Booking tickets will be injected here dynamically -->
                    </div>
                </div>
            </div>        
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    loadSurveys();
    function loadSurveys() {
        $.ajax({
            url: "{{ route('surveys.list') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#feedback-activity-feed').empty();

                function formatDate(datetime) {
                    const date = new Date(datetime);
                    const options = { year: 'numeric', month: 'short', day: 'numeric' };
                    return date.toLocaleDateString('en-US', options);
                }

                const groupedData = data.data.reduce((acc, item) => {
                    const date = formatDate(item.created_at);
                    if (!acc[date]) {
                        acc[date] = [];
                    }
                    acc[date].push(item);
                    return acc;
                }, {});

                function createDateGroup(date, items) {
                    const groupTitle = $('<h4></h4>').text(date).addClass('date-group-title');
                    $('#feedback-activity-feed').append(groupTitle);
                    
                    items.forEach(item => {
                        const listItem = $('<li></li>').addClass('feed-item');

                        const time = $('<time></time>').addClass('date').attr('datetime', item.created_at).text(date);

                        const text = $('<p></p>').addClass('text').html(
                            `Survey taken by a ${item.person_type} from the ${item.group_type} group in ${item.address}`
                        );

                        listItem.append(text);
                        $('#feedback-activity-feed').append(listItem);
                    });
                }

                Object.keys(groupedData).forEach(date => {
                    createDateGroup(date, groupedData[date]);
                });
            },
            error: function(error) {
                console.error('Error fetching survey:', error);
            }
        });
    }

    loadFeedbacks();
    function loadFeedbacks() {
        $.ajax({
        url: "{{ route('feedback.list') }}",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const _counts = {
                food_resto: { angry: 0, sad: 0, neutral: 0, smile: 0, happy: 0 },
                accomodations: { angry: 0, sad: 0, neutral: 0, smile: 0, happy: 0 },
                recreations_act: { angry: 0, sad: 0, neutral: 0, smile: 0, happy: 0 },
                place: { angry: 0, sad: 0, neutral: 0, smile: 0, happy: 0 },
                services: { angry: 0, sad: 0, neutral: 0, smile: 0, happy: 0 },
            };

            // Count ratings for each service
            data.data.forEach(entry => {
                const service = entry.services;
                const rating = entry.ratings;

                console.log(service);
                if (_counts[service] && _counts[service][rating] !== undefined) {
                    _counts[service][rating]++;
                }
            });

            // Update the HTML with the counts
            for (const service in _counts) {
                for (const rating in _counts[service]) {
                    $(`#${service}_${rating}`).text(_counts[service][rating]);
                }
            }

            const counts = {
                angry: 0,
                sad: 0,
                neutral: 0,
                smile: 0,
                happy: 0
            };

            data.data.forEach(item => {
                if (item.ratings in counts) {
                    counts[item.ratings]++;
                }
            });
            function createCircle(id, value, color) {
                Circles.create({
                    id: id,
                    radius: 45,
                    value: value,
                    maxValue: data.data.length,
                    width: 7,
                    text: value,
                    colors: ['#f1f1f1', color],
                    duration: 400,
                    wrpClass: 'circles-wrp',
                    textClass: 'circles-text',
                    styleWrapper: true,
                    styleText: true
                });
            }

            createCircle('circles-1', counts.angry, '#F25961'); // Angry
            createCircle('circles-2', counts.sad, '#F1C40F');   // Sad
            createCircle('circles-3', counts.neutral, '#BDC3C7'); // Neutral
            createCircle('circles-4', counts.smile, '#2ECC71');  // Smile
            createCircle('circles-5', counts.happy, '#3498DB');  // Happy
        },
        error: function(error) {
            console.error('Error fetching feedback:', error);
        }
    });
    }

    function loadBookings(timeframe) {
        $.ajax({
            url: "{{ route('bookings.list.table') }}",
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var bookingList = '';

                data.data.forEach(function (booking) {

                    var bookingDate = moment(booking.created_at).format('MMMM Do YYYY, h:mm A');
                    var timeAgo = moment(booking.created_at).fromNow(); 

                    var now = moment();
                    if (timeframe === 'today' && !moment(booking.created_at).isSame(now, 'day')) {
                        return;
                    }
                    if (timeframe === 'week' && !moment(booking.created_at).isSame(now, 'week')) {
                        return;
                    }
                    if (timeframe === 'month' && !moment(booking.created_at).isSame(now, 'month')) {
                        return;
                    }

                    bookingList += `
                    <div class="d-flex">
                        <div class="avatar avatar-${booking.status === 'open' ? 'online' : 'offline'}">
                            <span class="avatar-title rounded-circle border border-white bg-${getColorForStatus(booking.status)}">${booking.name.charAt(0).toUpperCase()}</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">${booking.name} 
                                <span class="text-${getStatusColor(booking.status)} pl-3">${booking.status}</span>
                            </h6>
                            <span class="text-muted">${booking.address || 'No additional notes'}</span><br/>
                            <span class="text-muted">Booked Date: ${moment(booking.checkin_date).format('MMM D')+'-'+moment(booking.checkout_date).format('D, YYYY') + '; '+ moment(booking.checkin_date).format('h:mm A')+'-'+moment(booking.checkout_date).format('h:mm A')|| 'No Data'}</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">${timeAgo}</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    `;
                });
                $('#booking-list').html(bookingList);
            },
            error: function (error) {
                console.error('Error fetching bookings:', error);
            }
        });
    }

    function getColorForStatus(status) {
        switch (status) {
            case 'pending':
                return 'warning';
            case 'open':
                return 'success';
            case 'closed':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    // Helper function to get the text color based on status
    function getStatusColor(status) {
        return status === 'pending' ? 'warning' : status === 'open' ? 'success' : 'muted';
    }

    // Handle tab clicks to load corresponding timeframe
    $('#pills-today').on('click', function () {
        loadBookings('today');
    });

    $('#pills-week').on('click', function () {
        loadBookings('week');
    });

    $('#pills-month').on('click', function () {
        loadBookings('month');
    });

    // Initially load the "Week" bookings
    loadBookings('today');
</script>
@endpush
