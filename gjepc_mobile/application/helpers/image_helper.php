<?php
/**
 * @name		CodeIgniter Advanced Images
 * @author		Jens Segers
 * @link		http://www.jenssegers.be
 * @license		MIT License Copyright (c) 2012 Jens Segers
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Image
 *
 * Generates a modified image source to work with the advanced images controller
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if (!function_exists('image')) {
    function image($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
    {
        $ci = &get_instance();

        if(!file_exists($destination) && $source_image!=''){
            $info = getimagesize($source_image);

            $imgtype = image_type_to_mime_type($info[2]);

            #assuming the mime type is correct
            switch ($imgtype) {
                case 'image/jpeg':
                    $source = imagecreatefromjpeg($source_image);
                    break;
                case 'image/gif':
                    $source = imagecreatefromgif($source_image);
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($source_image);
                    break;
                default:
                    die('Invalid image type.');
            }

            #Figure out the dimensions of the image and the dimensions of the desired thumbnail
            $src_w = imagesx($source);
            $src_h = imagesy($source);


            #Do some math to figure out which way we'll need to crop the image
            #to get it proportional to the new size, then crop or adjust as needed

            $x_ratio = $tn_w / $src_w;
            $y_ratio = $tn_h / $src_h;

            if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
                $new_w = $src_w;
                $new_h = $src_h;
            } elseif (($x_ratio * $src_h) < $tn_h) {
                $new_h = ceil($x_ratio * $src_h);
                $new_w = $tn_w;
            } else {
                $new_w = ceil($y_ratio * $src_w);
                $new_h = $tn_h;
            }

            $newpic = imagecreatetruecolor(round($new_w), round($new_h));
            imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
            $final = imagecreatetruecolor($tn_w, $tn_h);
            $backgroundColor = imagecolorallocate($final, 255, 255, 255);
            imagefill($final, 0, 0, $backgroundColor);
            //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
            imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

            #if we need to add a watermark
            if ($wmsource) {
                #find out what type of image the watermark is
                $info    = getimagesize($wmsource);
                $imgtype = image_type_to_mime_type($info[2]);

                #assuming the mime type is correct
                switch ($imgtype) {
                    case 'image/jpeg':
                        $watermark = imagecreatefromjpeg($wmsource);
                        break;
                    case 'image/gif':
                        $watermark = imagecreatefromgif($wmsource);
                        break;
                    case 'image/png':
                        $watermark = imagecreatefrompng($wmsource);
                        break;
                    default:
                        die('Invalid watermark type.');
                }

                #if we're adding a watermark, figure out the size of the watermark
                #and then place the watermark image on the bottom right of the image
                $wm_w = imagesx($watermark);
                $wm_h = imagesy($watermark);
                imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

            }
            
            if (imagejpeg($final, $destination, $quality)) {
                return $destination;
            }
            return false;

        }
        else
            return $destination;
        
    }
}
