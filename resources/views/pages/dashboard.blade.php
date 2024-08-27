@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5"></div>
</div>

<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Overall statistics</div>
                    <div class="card-category">Daily information about statistics in system</div>
                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-1"></div>
                            <h6 class="fw-bold mt-3 mb-0">New Users</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-2"></div>
                            <h6 class="fw-bold mt-3 mb-0">Sales</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-3"></div>
                            <h6 class="fw-bold mt-3 mb-0">Subscribers</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
    <div class="row">
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
                    <ol class="activity-feed">
                        <li class="feed-item feed-item-secondary">
                            <time class="date" datetime="9-25">Sep 25</time>
                            <span class="text">Responded to need <a href="#">"Volunteer opportunity"</a></span>
                        </li>
                        <li class="feed-item feed-item-success">
                            <time class="date" datetime="9-24">Sep 24</time>
                            <span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>
                        </li>
                        <li class="feed-item feed-item-info">
                            <time class="date" datetime="9-23">Sep 23</time>
                            <span class="text">Joined the group <a href="single-group.php">"Boardsmanship Forum"</a></span>
                        </li>
                        <li class="feed-item feed-item-warning">
                            <time class="date" datetime="9-21">Sep 21</time>
                            <span class="text">Responded to need <a href="#">"In-Kind Opportunity"</a></span>
                        </li>
                        <li class="feed-item feed-item-danger">
                            <time class="date" datetime="9-18">Sep 18</time>
                            <span class="text">Created need <a href="#">"Volunteer Opportunity"</a></span>
                        </li>
                        <li class="feed-item">
                            <time class="date" datetime="9-17">Sep 17</time>
                            <span class="text">Attending the event <a href="single-event.php">"Some New Event"</a></span>
                        </li>
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
                                    <a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="avatar avatar-online">
                            <span class="avatar-title rounded-circle border border-white bg-info">J</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">Joko Subianto <span class="text-warning pl-3">pending</span></h6>
                            <span class="text-muted">I am facing some trouble with my viewport. When i start my</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">8:40 PM</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="avatar avatar-offline">
                            <span class="avatar-title rounded-circle border border-white bg-secondary">P</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">Prabowo Widodo <span class="text-success pl-3">open</span></h6>
                            <span class="text-muted">I have some query regarding the license issue.</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">1 Day Ago</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="avatar avatar-away">
                            <span class="avatar-title rounded-circle border border-white bg-danger">L</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">Lee Chong Wei <span class="text-muted pl-3">closed</span></h6>
                            <span class="text-muted">Is there any update plan for RTL version near future?</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">2 Days Ago</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="avatar avatar-offline">
                            <span class="avatar-title rounded-circle border border-white bg-secondary">P</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">Peter Parker <span class="text-success pl-3">open</span></h6>
                            <span class="text-muted">I have some query regarding the license issue.</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">2 Day Ago</small>
                        </div>
                    </div>
                    <div class="separator-dashed"></div>
                    <div class="d-flex">
                        <div class="avatar avatar-away">
                            <span class="avatar-title rounded-circle border border-white bg-danger">L</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">Logan Paul <span class="text-muted pl-3">closed</span></h6>
                            <span class="text-muted">Is there any update plan for RTL version near future?</span>
                        </div>
                        <div class="float-right pt-1">
                            <small class="text-muted">2 Days Ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush
