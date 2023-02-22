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
    /**
     * query for get latest slider
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function getLatestSlider()
    {
        return Slider::order()->get();
    }
    /**
     * query for get slider item by id
     * 
     * @param Request request The request object
     * 
     * @return The service that was find.
     */
    public function getSliderItemById($id)
    {
        return Slider::findOrfail($id);
    }
    /**
     * query for create new slider
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createNewSlider($data)
    {
        return Slider::create($data);
    }
    /**
     * query for update slider
     * 
     * @param data request The request object
     * @param id request The request string
     * 
     * @return The service that was store.
     */
    public function updateSlider($data, $id)
    {
        return Slider::where('id', $id)->update($data);
    }
    /**
     * query for delete slider
     * 
     * @param id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deleteSlider($id)
    {
        return Slider::destroy($id);
    }
}