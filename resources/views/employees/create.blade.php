@extends('layouts.app', [
'class' => '',
'elementActive' => 'employees'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card  shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 h3_title">Employee</h3>
                            </div>
                            <div class="col-4 text-right create-region-btn">
                                <a href="{{ route('employees') }}" class="btn btn-sm btn-primary"
                                    id="create-region-btn">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('notification.index')
                        <form method="post" action="{{ route('employee.store') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="created_by_users_id" value="{{Auth::user()->id}}"
                                    class="form-control form-control-alternative">
                                    {{-- accodion start --}}
                                    <div class="accordion accordion-secondary">
                                        <div class="card">
                                            <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="span-icon">
                                                    <div class="flaticon-add-user"></div>
                                                </div>
                                                <div class="span-title">
                                                    Personal Data
                                                </div>
                                                <div class="span-mode"></div>
                                            </div>
                                    
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    <!-- SmartWizard html -->
                                                    <div id="smartwizard">
                                                        <ul class="nav">
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#step-1">
                                                                    <div class="num">1</div>
                                                                    Basic Information
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#step-2">
                                                                    <span class="num">2</span>
                                                                    Immediate/Personal Contact Information
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#step-3">
                                                                    <span class="num">3</span>
                                                                    Parents Information
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link " href="#step-4">
                                                                    <span class="num">4</span>
                                                                    Benefits/Tax ID Numbers
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link " href="#step-5">
                                                                    <span class="num">5</span>
                                                                    Physical Description
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    
                                                        <div class="tab-content">
                                                            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                                                <div class="form-group">
                                                                    <label for="squareInput">Date Filed</label>
                                                                    <input type="date" class="form-control input-square" id="squareInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Employeed ID</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Last Name</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">First Name</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Middle Name</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareSelect">Sex</label>
                                                                    <select class="form-control input-square" id="squareSelect">
                                                                        <option>Male</option>
                                                                        <option>Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Birthdate</label>
                                                                    <input type="date" class="form-control input-square" id="squareInput">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Place of Birth</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareSelect">Civil Status</label>
                                                                    <select class="form-control input-square" id="squareSelect">
                                                                        <option>Single</option>
                                                                        <option>Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Nationality</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Religion</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                                                <div class="form-group">
                                                                    <label for="squareInput">Address</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Mobile</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Office</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Home</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Email Address</label>
                                                                    <input type="email" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                                                <div class="form-group">
                                                                    <label for="squareInput">Father's Name</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareSelect">Living/Deceased</label>
                                                                    <select class="form-control input-square" id="squareSelect">
                                                                        <option>Living</option>
                                                                        <option>Deceased</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Occupation</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Mother's Name</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareSelect">Living/Deceased</label>
                                                                    <select class="form-control input-square" id="squareSelect">
                                                                        <option>Living</option>
                                                                        <option>Deceased</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Occupation</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                                                <div class="form-group">
                                                                    <label for="squareInput">SSS</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">PhilHealth</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">TIN</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">PAG-IBIG</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">PERAA</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareSelect">Tax Status</label>
                                                                    <select class="form-control input-square" id="squareSelect">
                                                                        <option>Living</option>
                                                                        <option>Deceased</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                                                <div class="form-group">
                                                                    <label for="squareInput">Height (in cm.)</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Weigth (in lbs.)</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareSelect">Blood Type</label>
                                                                    <select class="form-control input-square" id="squareSelect">
                                                                        <option>Living</option>
                                                                        <option>Deceased</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="squareInput">Distinguishing Mark</label>
                                                                    <input type="text" class="form-control input-square" id="squareInput" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                        <!-- Include optional progressbar HTML -->
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <div class="span-icon">
                                                    <div class="flaticon-add-user"></div>
                                                </div>
                                                <div class="span-title">
                                                    Contact Information
                                                </div>
                                                <div class="span-mode"></div>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header collapsed" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <div class="span-icon">
                                                    <div class="flaticon-add-user"></div>
                                                </div>
                                                <div class="span-title">
                                                    Spouce/Chilren Information
                                                </div>
                                                <div class="span-mode"></div>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end --}}
                                <div class="">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('employees.script')
@push('scripts')
<script>
    // SmartWizard initialize
    $('#smartwizard').smartWizard({
    selected: 0, // Initial selected step, 0 = first step
    theme: 'arrows', // theme for the wizard, related css need to include for other than default theme
    justified: true, // Nav menu justification. true/false
    autoAdjustHeight: true, // Automatically adjust content height
    backButtonSupport: true, // Enable the back button support
    enableUrlHash: true, // Enable selection of the step based on url hash
    transition: {
        animation: 'fade', // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
        speed: '400', // Animation speed. Not used if animation is 'css'
        easing: '', // Animation easing. Not supported without a jQuery easing plugin. Not used if animation is 'css'
        prefixCss: '', // Only used if animation is 'css'. Animation CSS prefix
        fwdShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on forward direction
        fwdHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on forward direction
        bckShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on backward direction
        bckHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on backward direction
    },
    toolbar: {
        position: 'bottom', // none|top|bottom|both
        showNextButton: true, // show/hide a Next button
        showPreviousButton: true, // show/hide a Previous button
        extraHtml: '' // Extra html to show on toolbar
    },
    anchor: {
        enableNavigation: true, // Enable/Disable anchor navigation
        enableNavigationAlways: false, // Activates all anchors clickable always
        enableDoneState: true, // Add done state on visited steps
        markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
        unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
        enableDoneStateNavigation: true // Enable/Disable the done state navigation
    },
    keyboard: {
        keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
        keyLeft: [37], // Left key code
        keyRight: [39] // Right key code
    },
    lang: { // Language variables for button
        next: 'Next',
        previous: 'Previous'
    },
    disabledSteps: [], // Array Steps disabled
    errorSteps: [], // Array Steps error
    warningSteps: [], // Array Steps warning
    hiddenSteps: [], // Hidden steps
    getContent: null // Callback function for content loading
    });
</script>
@endpush