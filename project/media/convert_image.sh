#!/bin/sh
if [ $# -ne 1 ]; then
    echo "Usage: convert_image [image.svg]"
    exit
fi

inkscape -z -w 36 -h 36 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_ldpi.png/'`
inkscape -z -w 48 -h 48 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_mdpi.png/'`
inkscape -z -w 72 -h 72 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_hdpi.png/'`
inkscape -z -w 96 -h 96 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_xhdpi.png/'`
inkscape -z -w 144 -h 144 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_xxhdpi.png/'`
inkscape -z -w 192 -h 192 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_xxxhdpi.png/'`
inkscape -z -w 512 -h 512 $1 -e `echo $1 | sed 's/\\(.*\\)\\.svg/\\1_web.png/'`
