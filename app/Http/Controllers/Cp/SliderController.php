<?php

namespace App\Http\Controllers\Cp;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Services\SliderService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;

class SliderController extends Controller
{
    private $sliderService;
    
    public function __construct()
    {
        $this->sliderService = new SliderService();
    }
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = $this->sliderService->getDatatables();
        return view('cp.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        return $this->sliderService->createSlider($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->sliderService->getDetailSlider($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->sliderService->updateSlider($request, $id);
    }


    public function changeSliderOrder(Request $request)
    {
       return $this->sliderService->changeSliderOrder($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->sliderService->deleteSlider($id);
    }
}
