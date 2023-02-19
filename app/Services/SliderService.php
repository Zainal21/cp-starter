<?php

namespace App\Services;

use DataTables;
use App\Helpers\Utils;
use Illuminate\Support\Str;
use App\Helpers\ResponseHelper;
use App\Repositories\SliderRepository;

class SliderService
{
    private $sliderRepository;
    
    public function __construct() 
    {
        $this->sliderRepository = new SliderRepository();
    }

    public function getDatatables()
    {
        $sliders = $this->sliderRepository->getLatestSlider();
        return $sliders;
        // return DataTables::of($sliders)
        // ->addColumn('action', function($row){
        //     $actionBtn = '-';
        //     $actionBtn = '<a class="edit btn btn-info btn-sm mx-2" href="'.route('post.edit', $row->id).'">Edit</a>';
        //     $actionBtn .= '<button onClick="deletePost(`'.$row->id.'`)" class="delete btn btn-danger btn-sm text-white mx-2">Delete</button>';
        //     return $actionBtn;
        // })
        // ->addColumn('order', function($row){
        //     return $row->order;
        // })
        // ->addColumn('caption', function($row){
        //     return $row->caption;
        // })
        // ->addColumn('image', function($row){
        //     return $row->image;
        // })
        // ->rawColumns(['action', 'order', 'caption', 'image'])
        // ->addIndexColumn()
        // ->make(true);
    }

    public function createSlider($request)
    {
        try {
            $file = $request->file('image');
            $sliderImage = $file->move('files/slider/', Utils::generateFileName($request->caption, $file));

            $slider = $this->sliderRepository->createNewSlider([
                'image' => $sliderImage,
                'caption' => $request->caption,
            ]);

            $slider->update([
                'order' => $slider->id
            ]);

            return ResponseHelper::success(1, 'Data Slider Berhasil disimpan');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Server Error');
        }
    }

}