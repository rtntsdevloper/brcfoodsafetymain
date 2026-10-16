<?php
require 'FFmpeg/vendor/autoload.php';

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;

// Create FFMpeg instance
$ffmpeg = FFMpeg::create([
    'ffmpeg.binaries'  => '/usr/bin/ffmpeg',   // path to ffmpeg
    'ffprobe.binaries' => '/usr/bin/ffprobe',  // path to ffprobe
]);

// Open .3gpp file
$audio = $ffmpeg->open('testing12.3gpp');

// Convert to MP3
$format = new Mp3();
$audio->save($format, 'testing12.mp3');

echo "Conversion complete!";
