<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     *
     */
    protected $width, $height, $imagePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imagePath, $width , $height)
    {
        $this->imagePath = $imagePath;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Image::make(public_path($this->imagePath))->resize($this->width,$this->height)->save();
    }
}
