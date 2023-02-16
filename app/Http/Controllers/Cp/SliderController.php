<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private $sliderService;
    
    public function __construct()
    {

    }
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('cp.slider.index',);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cp.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $file = $request->file('image');
        $sliderImage = $file->move('files/slider/', generateFileName($request->caption, $file));

        $slider = Slider::create([
            'image' => $sliderImage,
            'caption' => $request->caption,
        ]);

        $slider->update([
            'order' => $slider->id
        ]);

        return redirect(route('cp.sliders.index'))->with('success', 'Slider berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('cp.slider.edit', [
            'slider' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'image' => 'image',
            'caption' => 'required'
        ]);

        if ($request->hasFile('image')) {
            removeFile($slider->image);
            $file = $request->file('image');
            $sliderImage = $file->move('files/slider/', generateFileName($request->caption, $file));
        }

        $slider->update([
            'image' => !empty($sliderImage) ? $sliderImage : $slider->image,
            'caption' => $request->caption,
        ]);

        return redirect(route('cp.sliders.index'))
                    ->with('success', 'Slider berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect(route('cp.sliders.index'))
                    ->with('success', 'Slider berhasil dihapus.');
    }
}
