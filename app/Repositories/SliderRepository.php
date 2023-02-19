<?php

namespace App\Repositories;

use App\Models\Slider;
use Illuminate\Support\Str;

interface SliderContract
{
    public function getLatestSlider();
    public function getSliderItemById($id);
    public function createNewSlider($data);
    public function updateSlider($data, $id);
    public function deleteSlider($id);
}

class SliderRepository implements SliderContract
{
    public function getLatestSlider()
    {
        return Slider::latest()->get();
    }

    public function getSliderItemById($id)
    {
        return Slider::where('id', $id)->first();
    }
    
    public function createNewSlider($data)
    {
        return Slider::create($data);
    }
    
    public function updateSlider($data, $id)
    {
        return Slider::where('id', $id)->update($data);
    }
    
    public function deleteSlider($id)
    {
        return Slider::destroy($id);
    }
}