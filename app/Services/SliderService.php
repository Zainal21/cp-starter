<?php

namespace App\Services;

use DataTables;
use App\Helpers\Utils;
use App\Models\Slider;
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
    /**
     * service to get datatables
     * 
     * @return The service that was find.
     */
    public function getDatatables()
    {
        try {
            $sliders = $this->sliderRepository->getLatestSlider();
            return $sliders;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            throw abort(500);
        }
    }
    /**
     * service to get details slider data by Id
     * 
     * @param Id service that was string.
     * 
     * @return The service that was find.
     */
    public function getDetailSlider($id)
    {
        try {
            $sliders = $this->sliderRepository->getSliderItemById($id);
            return ResponseHelper::success($sliders, 'Data Slider Berhasil disimpan');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
    /**
     * service to create new slider
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
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
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to change slider order
     * 
     * @param Request request The request object
     * 
     * @return The service that was updated.
     */
    public function changeSliderOrder($request)
    {
        try {
            $currentSlider = $this->sliderRepository->getSliderItemById($request->id);
            $currentSliderOrder = $currentSlider->order;
            if ($request->type == 'up') {
                $previousSlider = $currentSlider->previous();
                $currentSlider->update([
                    'order' => $previousSlider->order
                ]);
                $previousSlider->update([
                    'order' => $currentSliderOrder
                ]);
            }
    
            if ($request->type == 'down') {
                $nextSlider = $currentSlider->next();
                $currentSlider->update([
                    'order' => $nextSlider->order
                ]);
                $nextSlider->update([
                    'order' => $currentSliderOrder
                ]);
            }
            return ResponseHelper::success(1, 'Urutan Slider berhasil di perbarui');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to update slider data
     * 
     * @param Request request The request object
     * 
     * @param Id request The request slider
     * 
     * @return The service that was updated.
     */
    public function updateSlider($request,$id)
    {
        try {
            $slider = $this->sliderRepository->getSliderItemById($id);
            if ($request->hasFile('image')) {
                Utils::removeFile($slider->image);
                $file = $request->file('image');
                $sliderImage = $file->move('files/slider/', Utils::generateFileName($request->caption, $file));
            }

            $slider->update([
                'image' => !empty($sliderImage) ? $sliderImage : $slider->image,
                'caption' => $request->caption,
            ]);
            return ResponseHelper::success(1, 'Data Slider berhasil di perbarui');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to delete slider 
     * 
     * @param Id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deleteSlider($id)
    {
        try {
            Utils::removeFile($this->sliderRepository->getSliderItemById($id)->image);
            $deleted = $this->sliderRepository->deleteSlider($id);
            return $deleted ? ResponseHelper::success(1, 'Data Slider berhasil dihapus') : ResponseHelper::error('Data Slider tidak ditemukan');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memuat data');
        }
    }

}