<?php

    $ffmpeg = trim(shell_exec('which ffmpeg')); // or better yet:
$ffmpeg = trim(shell_exec('type -P ffmpeg'));

    if (empty($ffmpeg))
{
    die('ffmpeg not available');
}

shell_exec($ffmpeg . ' -i version');?>