<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use App\Models\SurveyModel;
use Illuminate\Http\Request;

use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reports.index',[
            'reports' => Reports::getReports()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }

    public function getChartDataActivity()
    {
        // Call the model method to get grouped reports
        $reports = Reports::getReportsChartActivity();

        // Format data for the chart
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [],
        ];

        $descriptions = $reports->pluck('description')->unique();

        foreach ($descriptions as $description) {
            $data = array_fill(0, 12, 0); // Initialize data for 12 months
            foreach ($reports->where('description', $description) as $report) {
                $data[$report->month - 1] = $report->count; // Populate monthly counts
            }

            $chartData['datasets'][] = [
                'label' => $description,
                'backgroundColor' => '#' . substr(md5($description), 0, 6), // Dynamic color
                'borderColor' => '#' . substr(md5($description), 0, 6),
                'data' => $data,
            ];
        }

        return response()->json($chartData);
    }

    public function getChartDataDemographic()
    {
        // Call the model method to get grouped reports
        $reports = Reports::getReportsChartDemographic();

        // Format data for the chart
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [],
        ];

        $descriptions = $reports->pluck('group_type')->unique();

        foreach ($descriptions as $description) {
            $data = array_fill(0, 12, 0); // Initialize data for 12 months
            foreach ($reports->where('group_type', $description) as $report) {
                $data[$report->month - 1] = $report->count; // Populate monthly counts
            }

            $chartData['datasets'][] = [
                'label' => $description,
                'backgroundColor' => '#' . substr(md5($description), 0, 6), // Dynamic color
                'borderColor' => '#' . substr(md5($description), 0, 6),
                'data' => $data,
            ];
        }

        return response()->json($chartData);
    }

    public function getChartDataBooking()
    {
        $reports = Reports::getReportsChartBooking();

        $chartData = [
            'labels' => $reports->pluck('accomodation_name'),
            'data' => $reports->pluck('count'),
            'backgroundColor' => $reports->pluck('accomodation_name')->map(function ($description) {
                return '#' . substr(md5($description), 0, 6);
            })
        ];
    
        return response()->json($chartData);
    }

    public function getChartDataFeedback()
    {
        // Call the model method to get grouped reports
        $reports = SurveyModel::select(
            DB::raw('MONTH(created_at) as month'),
            'ratings',
            DB::raw('COUNT(*) as count')
        )
        ->where('type','=','feedback')
        ->groupBy('month','ratings')
        ->get();

        // Format data for the chart
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [],
        ];

        $descriptions = $reports->pluck('ratings')->unique();

        foreach ($descriptions as $description) {
            $data = array_fill(0, 12, 0); // Initialize data for 12 months
            foreach ($reports->where('description', $description) as $report) {
                $data[$report->month - 1] = $report->count; // Populate monthly counts
            }

            $chartData['datasets'][] = [
                'label' => $description,
                'backgroundColor' => '#' . substr(md5($description), 0, 6), // Dynamic color
                'borderColor' => '#' . substr(md5($description), 0, 6),
                'data' => $data,
            ];
        }

        return response()->json($chartData);
    }
}
