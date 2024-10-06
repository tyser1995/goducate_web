<?php

namespace App\Http\Controllers;

use App\Models\SurveyModel;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    function __construct()
    {
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.survey.index',[
            'surveys' => SurveyModel::getSurvey()
        ]);
    }

    public function index_feedback()
    {
        $feedbacks = SurveyModel::getFeedbackCount();
        return view('pages.feedback_form.index', compact('feedbacks'));
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
     * @param  \App\Models\SurveyModel  $surveyModel
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyModel $surveyModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SurveyModel  $surveyModel
     * @return \Illuminate\Http\Response
     */
    public function edit(SurveyModel $surveyModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyModel  $surveyModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyModel  $surveyModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function survey_data(){
        $survey = SurveyModel::getSurvey();

        return response()->json([
            'success' => true,
            'data' => $survey
        ], 200);
    }

    public function survey_page()
    {
        //
        return view('pages.survey_page');
    }

    public function register(Request $request)
    {
        SurveyModel::createSurvey($request->all());
        return redirect()->route('_survey')->withStatus(__('Successfully created.'));
    }

    public function feedback_data(){
        $survey = SurveyModel::getFeedback();

        return response()->json([
            'success' => true,
            'data' => $survey
        ], 200);
    }

    public function feedback_page()
    {
        //
        return view('pages.feedback_page');
    }

    public function feedback(Request $request)
    {
        if($request['ratings'] == null)
            return redirect()->route('_feedback')->withError(__('Please select a mood rating.'));

        SurveyModel::createFeedback($request->all());
        return redirect()->route('_feedback')->withStatus(__('Successfully submitted.'));
    }
}
