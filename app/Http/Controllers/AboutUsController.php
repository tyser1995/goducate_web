<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.aboutus.index',[
            'aboutus' => AboutUs::getAboutUsPage()
        ]);
    }

    public function aboutus_page()
    {
        //
        return view('pages.aboutus',[
            'aboutus' => AboutUs::getAboutUsPage()
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
        return view('pages.aboutus.create');
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
        AboutUs::createAboutUsPage($request->all());
        return redirect()->route('about.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function show(AboutUs $aboutUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $about_us = AboutUs::getAboutUsPageById($id);
        return view('pages.aboutus.edit',[
            'about' => $about_us
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        AboutUs::updateAboutUsPage($id, $request->all());
        return redirect()->route('about.index')->withStatus(__('Successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        AboutUs::deleteAboutUsPage($id);
        return redirect()->route('about.index')->withStatus(__('Deleted successfully'));
    }
}
