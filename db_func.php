<?php

function formatDateAndTime($date) {
//Saturday, 24 May 2014 at 7:30 PM 
    return date('l,d M Y  H:i A', strtotime($date));
}

function leadingZero($value) {
    return str_pad($value, 2, '0', STR_PAD_LEFT);
}

function emailText($value) {
    $value = stripslashes(trim($value));
    $value = str_replace("“", "\"", $value);
    $value = str_replace("”", "\"", $value);
    $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
    $value = html_entity_decode($value, ENT_QUOTES);
    return stripslashes($value);
}

function sendEmail($to, $from, $subject, $message) {
    $to = emailText($to);
    $subject = emailText($subject);
    $message = emailText($message);

    $message = str_replace("<script>", "&lt;script&gt;", $message);
    $message = str_replace("</script>", "&lt;/script&gt;", $message);
    $message = str_replace("<SCRIPT>", "&lt;script&gt;", $message);
    $message = str_replace("</SCRIPT>", "&lt;/script&gt;", $message);


    $bcc1 = "sanjib.pradhan16@gmail.com";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers.= 'From:' . $from . "\r\n";
    $headers.= 'BCC:' . $bcc1 . "\r\n";

//echo $to."<br/>".$subject."<br/>".$message."<br/>".$headers;
//exit;

    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

function priceNumField($price) {
    if ($price == 0.00 || $price == 0.0) {
        return 0;
    } else {
        return $price;
    }
}

function checkSeoUrl($value) {

    if (strstr($value, " ")) {
        return false;
    } else {
        return true;
    }
}

function makeSeoUrl($url) {
    if ($url) {
        $value = preg_replace("![^a-z0-9]+!i", "-", $url);
        return strtolower($value);
    }
}

function getRealIpAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function generatePassword($length) {
    $vowels = 'aeuy';
    $consonants = '3@Z6!29G7#$QW4';
    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

function getLocationByIp($ip) {
//$ip = "119.226.151.75";
    $url = 'http://api.hostip.info/get_html.php?ip=' . $ip . '&position=true';
    $data = file_get_contents($url);
    $a = array();
    $keys = array('Country', 'City', 'Latitude', 'Longitude', 'IP');
    $keycount = count($keys);
    for ($r = 0; $r < $keycount; $r++) {
        $sstr = substr($data, strpos($data, $keys[$r]), strlen($data));
        if ($r < ($keycount - 1)) {
            $sstr = substr($sstr, 0, strpos($sstr, $keys[$r + 1]));
        }
        $s = explode(':', $sstr);
        $a[$keys[$r]] = trim($s[1]);
    }
    return $a;
}

function isEmail($email) {
    if (eregi("^[^@ ]+@[^@ ]+\.[^@ ]+$", $email)) {
        return true;
    } else {
        return false;
    }
}

function imageExists($dir, $image) {
    if ($image && file_exists($dir . $image)) {
        return true;
    } else {
        return false;
    }
}

function inputCms($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = mysql_real_escape_string($value);
    return $value;
}

function displayCms($value) {
    $value = trim($value);
    $value = stripslashes($value);
    return $value;
}

function formatText($value) {
    $value = str_replace("“", "\"", $value);
    $value = str_replace("”", "\"", $value);
    $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
    $value = stripslashes($value);
    $value = html_entity_decode($value, ENT_QUOTES);
    $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
    $value = strtr($value, $trans);
    $value = stripslashes(trim($value));
    return $value;
}

function formatText1($value) {
    $value = str_replace("“", "\"", $value);
    $value = str_replace("”", "\"", $value);
    $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
    $value = stripslashes($value);
    $value = stripslashes(trim($value));
    $value = str_replace("'", "", $value);
    $value = str_replace("\"", "", $value);
    return $value;
}

function formatCms($value) {
    $value = stripslashes(trim($value));
    $value = str_replace("“", "\"", $value);
    $value = str_replace("”", "\"", $value);
    $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
    $value = str_replace("~", "&#126;", $value);
    $value = str_replace("a href=", "a target='_blank' href=", $value);

    return stripslashes($value);
}

function shortLength($value, $len) {
    $value_format = formatText($value);
    $value_raw = html_entity_decode($value_format, ENT_QUOTES);

    if (strlen($value_raw) > $len) {
        $value_strip = substr($value_raw, 0, $len);
        $value_strip = formatText($value_strip);
        $lengthvalue = "<span title='" . $value_format . "'>" . $value_strip . "...</span>";
    } else {
        $lengthvalue = $value_format;
    }
    return $lengthvalue;
}

function formatPrice($value) {
    $value = stripslashes(trim($value));
    $val = substr($value, -2);

    if ($val == 0) {
        return "$" . substr($value, 0, -3);
    } else {
        return "$" . $value;
    }
}

function dateDisplay($datetime) {
    if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
        return date("m/d/Y", strtotime($datetime));
    } else {
        return false;
    }
}

function datetimeDisplay($datetime) {
    if (($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") || $datetime == "00:00:00") {
        return date("m/d/Y  g:i A", strtotime($datetime));
    } else {
        return false;
    }
}

function timeDisplay($datetime) {
    if (($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") || $datetime == "00:00:00") {
        return date("g:i A", strtotime($datetime));
    } else {
        return false;
    }
}

function onlyDateView($date) {
    if ($date != "" && $date != "NULL" && $date != "0000-00-00") {
        return date("m/d/Y", strtotime($date));
    } else {
        return false;
    }
}

function imageSize($imgpath) {
    $size = "";
    $inbytes = filesize($imgpath);
    if ($inbytes > 1024) {
        $size1 = $inbytes / 1024;
        $size = number_format($size1, 2) . " Kb";
    }
    if ($size1 > 1024) {
        $size1 = $inbytes / (1024 * 1024);
        $size = number_format($size1, 2) . " Mb";
    }
    if (!$size) {
        $size = $inbytes . " bytes";
    }
    return $size;
}

function imageResolution($imgpath) {
    list($width, $height, $type, $attr) = getimagesize($imgpath);
    return $width . " x " . $height;
}

# Param1: Larger date,Param2: Smaller date

function dateDiff($date1, $date2, $type) {
    $prefix = "";
    $diff = strtotime($date1) - strtotime($date2);
    if ($diff < 0) {
        $prefix = "-";
    }
    $diff = abs($diff);
    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

    if ($type == "days") {
        return $prefix . $days;
    } elseif ($type == "months") {
        return $prefix . $months;
    } elseif ($type == "years") {
        return $prefix . $years;
    }
}

function dateDirrerence($date1, $date2, $type = null) {
    $date1 = $date1;
    $date2 = $date2;

    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $day1 = date('d', $ts1);
    $day2 = date('d', $ts2);
    if ($type == "year") {
        $diff = ($year2 - $year1);  //Get year
    } elseif ($type == "month") {
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);  //Get month
    } else {
        $diff = (($month2 - $month1) * 30) + ($day2 - $day1);  //Get Days
    }
    return $diff;
}

function pagingShowRecords($total_records, $page_limit, $page) {

    if ($total_records) {

        $numofpages = $total_records / $page_limit;

        for ($j = 1; $j <= $numofpages; $j++) {
            
        }

        $start = $page * $page_limit - $page_limit;

        if ($page == $j) {
            $start1 = $start + 1;
            $retRec = $start1 . " - " . $total_records . " of " . $total_records;
        } else {
            $start1 = $start + 1;
            $retRec = $start1 . " - " . $page * $page_limit . " of " . $total_records;
        }
        return $retRec;
    } else {
        return false;
    }
}

function pagingNumbers($total_records, $page_limit, $page, $curpage, $urlvalue = NULL) {
//return $curpage;

    if (strstr($curpage, "feedback.php")) {
        $pageurl = "&page";
    } else {
        $pageurl = "?page";
    }
    $data = "";
    if ($page_limit < $total_records) {
        if ($page != 1) {
            $pageprev = $page - 1;
            $data.="&lt;&nbsp;<a href=\"$curpage" . $pageurl . "=$pageprev$urlvalue\" style='text-decoration:none'><span class=\"active_box\">Prev</span></a></span>&nbsp;";
        } else {
            $data.="<span class=\"inactive_box\" >&lt;&nbsp;Prev</span>";
        }
        $numofpages = $total_records / $page_limit;

        for ($i = 1; $i <= $numofpages; $i++) {
            if ($i == $page) {
                $data.= "&nbsp;<span class='inactive_box'>" . $i . "</span>&nbsp;";
            } else {
                $data.="&nbsp;<a href=\"$curpage" . $pageurl . "=$i$search_string$urlvalue\" style='text-decoration:none'><span class=\"active_box\">$i</span></a> ";
            }
        }
        if (($total_records % $page_limit) != 0) {
            if ($i == $page) {
                $data.="<span class='inactive_box'>" . $i . "</span>";
            } else {
                $data.="<a href=\"$curpage" . $pageurl . "=$i$search_string$urlvalue\" style='text-decoration:none'><span class=\"active_box\">$i</span></a> ";
            }
        }
        if (($total_records - ($page_limit * $page)) > 0) {
            $pagenext = $page + 1;
            $data.="&nbsp;<a href=\"$curpage" . $pageurl . "=$pagenext$urlvalue\" style='text-decoration:none'><span class=\"active_box\" >Next</span></a>&nbsp;&gt;";
        } else {
            $data.="&nbsp;<span class=\"inactive_box\">Next&nbsp;&gt;</span>";
        }
    }
    return $data;
}


//Image or File Upload Functions
function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}
function uploadThreeCustomImages($tmp_name, $name, $large, $middle, $thumb, $lwidth, $mwidth, $twidth) { {

        if ($name) {
            $image = strtolower($name);
            $extname = getExtension($image);
            if (($extname != 'gif') && ($extname != 'jpg') && ($extname != 'jpeg') && ($extname != 'png') && ($extname != 'bmp')) {
                return false;
            } else {
                if ($extname == "jpg" || $extname == "jpeg") {
                    $src = imagecreatefromjpeg($tmp_name);
                } else if ($extname == "png") {
                    $src = imagecreatefrompng($tmp_name);
                } else {
                    $src = imagecreatefromgif($tmp_name);
                }

                list($width, $height) = getimagesize($tmp_name);


                $newwidth = $lwidth;
                $newheight = ($height / $width) * $newwidth;
                $tmp = imagecreatetruecolor($newwidth, $newheight);

                $newwidth2 = $twidth;
                $newheight2 = ($height / $width) * $newwidth2;
                $tmp2 = imagecreatetruecolor($newwidth2, $newheight2);

                $newwidth3 = $mwidth;
                $newheight3 = ($height / $width) * $newwidth3;
                $tmp3 = imagecreatetruecolor($newwidth3, $newheight3);

                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                imagecopyresampled($tmp2, $src, 0, 0, 0, 0, $newwidth2, $newheight2, $width, $height);

                imagecopyresampled($tmp3, $src, 0, 0, 0, 0, $newwidth3, $newheight3, $width, $height);

                $micro_date = microtime();
                $date_array = explode(" ", $micro_date);
                $date = date("Y-m-d H:i:s", $date_array[1]);
                $filepath = md5($date . $date_array[0]) . "." . $extname;

                $filename = $large . $filepath;
                $filename2 = $thumb . "thumb_" . $filepath;
                $filename3 = $thumb . "middle_" . $filepath;
                imagejpeg($tmp, $filename, 100);
                imagejpeg($tmp2, $filename2, 100);
                imagejpeg($tmp3, $filename3, 100);
                imagedestroy($src);
                imagedestroy($tmp);
                imagedestroy($tmp2);
                imagedestroy($tmp3);
                return $filepath;
            }
        }
    }

    function pr($data) {
        echo "<pre>";
        print_r($data);
        exit;
    }

    function removeContacts($string) {
        $patterns = array('<[\w.]+@[\w.]+>', '/[0-9]{3}/');
        $matches = array('', '');
        $string = preg_replace($patterns, $matches, $string);
        return $string;
    }

    function inputText($value) {
        $value = trim($value);
        $value = addslashes($value);
        $value = mysql_real_escape_string($value);
        $value = str_replace("<", "&lt;", $value);
        $value = str_replace(">", "&gt;", $value);
        return $value;
    }

    function dataModel($data = array(), $table = NULL, $datefield = 1) {
        if (!$table) {
            $table = @$data['table'];
        }
        $id = @$data['id'];
        $query = "";
        if (is_array($data)) {
            foreach ($data as $field => $value) {
                if ($field != 'table' && $field != 'id' && !strstr($field, "-") && trim($field)) {
// Create MD5 Password
                    if ($field == 'user_password') {
                        $value = md5($value);
                    }
// Check for date and convert it to database format
                    if (stristr("date_", $field) || stristr("_date", $field)) {
                        $value = date('Y-m-d', strtotime($value));
                    }
                    $query.="`" . $field . "`='" . inputText($value) . "',";
                }
            }
            $query = substr($query, 0, -1);
        }

        if ($query) {
            if ($id) {
                if ($datefield) {
                    $query = "UPDATE " . $table . " SET " . $query . ",modified='" . CURDT . "' WHERE id=" . $id;
                } else {
                    $query = "UPDATE " . $table . " SET " . $query . " WHERE id=" . $id;
                }
            } else {
                if ($table == "users") {
                    $uniq_id = generateUniqNumber();
                    $query.=",uniq_id='" . $uniq_id . "'";
                }
                if ($datefield) {
//echo "INSERT INTO ".$table." SET ".$query.",created='".CURDT."'";
                    $query = "INSERT INTO " . $table . " SET " . $query . ",created='" . CURDT . "'";
                } else {
                    $query = "INSERT INTO " . $table . " SET " . $query;
                }
            }
//echo $query;
//exit;
            if (mysql_query($query)) {
                if (!$id) {
                    $id = mysql_insert_id();
                }
                return $id;
            }
        }
//exit;
        return false;
    }

    function generateUniqNumber($id = NULL) {
        $uniq = uniqid(rand());
        if ($id) {
            return md5($uniq . time() . $id);
        } else {
            return md5($uniq . time());
        }
    }

    function transactionId() {
//$uniq = rand(1,9);
        return $_SESSION['USER_ID'] . time();
    }

    function sendEmail1($to, $from = FROM_EMAIL, $subject, $message, $header = 1, $footer = 1) {
        if (!$from) {
            $from = FROM_EMAIL;
        }
        if ($header) {
            $hdr = "<tr><td align='left' valign='top' style='font:12px Verdana;'>
" . EMAIL_HEADER . "
</td>	
</tr>
<tr><td>&nbsp;</td></tr>";
        }
        if ($footer) {
            $ftr = "<tr><td>&nbsp;</td></tr>
<tr>
<td align='left' valign='top' style='font:12px Verdana;'>
" . EMAIL_FOOTER . "
</td>	
</tr>";
        }
        $message = "<table cellspacing='2' cellpadding='2' align='left' width='650' style='border:2px solid #6AA002;'>
" . $hdr . "
<tr>
<td align='left' valign='top' style='font:12px Verdana;'>
" . $message . "
</td>	
</tr>
" . $ftr . "
</table>
";

        $to = emailText($to);
        $subject = emailText($subject);
        $message = $message;

        /* $message = str_replace("<script>","&lt;script&gt;",$message);
          $message = str_replace("</script>","&lt;/script&gt;",$message);
          $message = str_replace("<SCRIPT>","&lt;script&gt;",$message);
          $message = str_replace("</SCRIPT>","&lt;/script&gt;",$message); */
        $from = "Rusupet Message <Message@rusupet.com>";
        $bcc1 = "webmaster@rusupet.com";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers.= 'From:' . $from . "\r\n";
        $headers.= 'BCC:' . $bcc1 . "\r\n";

////echo $from."<br/>".$to."<br/>".$subject."<br/>".$message."<br/>".$headers;
//exit;
//return true;

        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    function makeSeoUrlhtml($url) {
        if ($url) {
            $url = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "-", $url);
            $value = trim($value, "-");
            $value . "html";
            return strtolower($value);
        }
    }

    function editorImagePath($cms) {
        if (strstr($cms, "/userfiles/")) {
            $cms = str_replace("/userfiles/", HTTP_ROOT . "userfiles/", $cms);
        }
        return formatCms($cms);
    }

    function setURL($name) {
        $name = formatText($name);
        if (strstr($name, " ")) {
            $value = str_replace(" ", "-", $name);
        }
        $value = urlencode($value);
        return $value;
    }

    function dateInsert($date) {
        if ($date != "" && $date != "NULL" && $date != "00/00/0000") {
            return date("Y-m-d", strtotime($date));
        } else {
            return false;
        }
    }

    function uploadImage($tmp_name, $name, $size, $path, $count) {
        if ($name) {
            $image = strtolower($name);
            $extname = substr(strrchr($image, "."), 1);
            if (($extname != 'gif') && ($extname != 'jpg') && ($extname != 'jpeg') && ($extname != 'png') && ($extname != 'bmp')) {
                return false;
            } else {
                list($width, $height) = getimagesize($tmp_name);
//$checkSize = round($size/1024);
                if ($width > 800) {
                    try {
                        if ($extname == "png") {
                            $src = imagecreatefrompng($tmp_name);
                        } elseif ($extname == "gif") {
                            $src = imagecreatefromgif($tmp_name);
                        } elseif ($extname == "bmp") {
                            $src = imagecreatefromwbmp($tmp_name);
                        } else {
                            $src = imagecreatefromjpeg($tmp_name);
                        }

                        $newwidth = 800;
                        $newheight = ($height / $width) * $newwidth;
//$newheight = 600;

                        $tmp = imagecreatetruecolor($newwidth, $newheight);

                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        $time = time() . $count;
                        $filepath = md5($time) . "." . $extname;
                        $targetpath = $path . $filepath;
                        imagejpeg($tmp, $targetpath, 100);
                        imagedestroy($src);
                        imagedestroy($tmp);
                    } catch (Exception $e) {
                        return false;
                    }
                } else {
                    $time = time() . $count;
                    $filepath = md5($time) . "." . $extname;
##################watermarklog################

                    function waterMark($fileInHD, $wmFile, $margin, $transparency = 30, $jpegQuality = 100) {

                        $ext = strtolower(substr(strrchr($fileInHD, "."), 1));
                        if ($ext == "jpg") {
                            $jpegImg = imagecreatefromjpeg($fileInHD);
                        } else if ($ext == "jpeg") {
                            $jpegImg = imagecreatefromjpeg($fileInHD);
                        } else if ($ext == "png") {
                            $jpegImg = imagecreatefrompng($fileInHD);
                        } else {
                            $jpegImg = imagecreatefromgif($fileInHD);
                        }
                        $wmImg = imagecreatefromgif($wmFile);
// $jpegImg = imagecreatefrompng($fileInHD);
                        $margin = "0,10,0,10";
// Water mark random position
                        $wmX = 92 ? $margin : (imageSX($jpegImg) - imageSX($wmImg)) - $margin;
                        $wmY = 92 ? $margin : (imageSY($jpegImg) - imageSY($wmImg)) - $margin;

// Water mark process
                        imagecopymerge($jpegImg, $wmImg, $wmX, $wmY, 0, 0, imageSX($wmImg), imageSY($wmImg), $transparency);

// Overwriting image

                        if ($ext == "jpg" || $ext == "jpeg") {
                            imagejpeg($jpegImg, $fileInHD, $jpegQuality);
                        } else if ($ext == "png") {
                            imagepng($jpegImg, $fileInHD, $jpegQuality);
                        } else if ($ext == "gif") {
                            imagegif($jpegImg, $fileInHD, $jpegQuality);
                        }
                    }

                    $random = '92';

                    copy($tmp_name, $path . $filepath);
                    $targetpath = $path . $filepath;

                    waterMark($targetpath, 'includes/logo.gif', $random);
                    header("location:editprofile.php?msg=" . $filepath);

##################end watermarklog################
//$targetpath = $path.$filepath; 

                    if (!is_dir($path)) {
                        mkdir($path);
                    }

//move_uploaded_file($tmp_name,$targetpath);
                }


                if (file_exists($targetpath)) {
                    return $filepath;
                } else {
                    return false;
                }
            }
        }
    }

    function nextDate($givenDateTime, $value, $type) {
        if ($givenDateTime) {
            $dat = explode(" ", $givenDateTime);
            $dat1 = explode("-", $dat[0]);
            $dat2 = explode(":", $dat[1]);
            if ($type == "day") {
                $next_dt = mktime($dat2[0], $dat2[1], $dat2[2], $dat1[1], $dat1[2] + $value, $dat1[0]);
            }
            if ($type == "month") {
                $next_dt = mktime($dat2[0], $dat2[1], $dat2[2], $dat1[1] + $value, $dat1[2], $dat1[0]);
            }
            $datetime = date("Y-m-d H:i:s", $next_dt);
            return $datetime;
        } else {
            return "";
        }
    }

# Param1: Larger date,Param2: Smaller date

    function dateDiff4($date1, $date2, $type) {
        $date1 = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date1, "datetime");
        $date2 = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date2, "datetime");
        $prefix = "";
        $diff = strtotime($date1) - strtotime($date2);
        if ($diff < 0) {
            $prefix = "-";
        }
        $diff = abs($diff);
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        if ($type == "days") {
            return $prefix . $days;
        } elseif ($type == "months") {
            return $prefix . $months;
        } elseif ($type == "years") {
            return $prefix . $years;
        }
    }
    
    function loginRedirect($email, $password, $remember) {

        if ($email && $password) {
            $password = md5($password);
            $qry = "";
            if ($type) {
                $qry = " AND type='" . $type . "'";
            }
//echo "SELECT * FROM ".TBL_USERS." WHERE user_name ='$email' AND password ='$password'"; //exit;
            $checkuser = mysql_query("SELECT * FROM " . TBL_USERS . " WHERE user_name ='$email' AND password ='$password'" . $qry);
//echo "SELECT * FROM ".TBL_USERS." WHERE user_email='$email' AND user_password='$password'".$qry;
            if (mysql_num_rows($checkuser) == 0) {
                $err = "Invalid login credentials!";
            } else {
                $err = "";
            }
        }
        if (!$err) {
            $getdata = mysql_fetch_assoc($checkuser);
            if ($getdata['is_active'] == 0) {
                $err = "Please check your email for Account activation !";
                return $err;
            } else {
                $id = $getdata['id'];
                $uniq_id = $getdata['user_unidue_id'];
                $type = $getdata['type'];
                $ip = getRealIpAddress();
//$last_login = mysql_fetch_array(mysql_query("select * from ".USER_LOGINS." where user_id='$id' order by id desc limit 1"));
//mysql_query("INSERT INTO ".USER_LOGINS." SET user_id='".$id."',created='".CURDT."',ip='".$ip."'");

                mysql_query("UPDATE " . TBL_USERS . " SET last_login='" . CURDT . "', last_login_ip = '$ip' WHERE user_unidue_id='$uniq_id'");

                if (!$getdata['fb_id'] && isset($_SESSION['USER_FB']) && $_SESSION['USER_FB']['id']) {
                    $qury = "";
                    if (!$getdata['photo']) {
                        $profimage = "http://graph.facebook.com/" . $_SESSION['USER_FB']['id'] . "/picture?type=large";
                        $ext = substr(strrchr($profimage, "."), 1);
                        $newImageName = $_SESSION['USER_FB']['id'] . "." . $ext;
                        if ($profimage) {
                            file_put_contents(DIR_PROFILE . $newImageName, file_get_contents($profimage));
                            $qury = ",photo='" . $newImageName . "'";
                        }
                    }
//$last_login = mysql_fetch_array(mysql_query("select * from ".USER_LOGINS." where user_id='$id' order by id desc limit 1"));
                    mysql_query("UPDATE " . USER_LOGINS . " SET fb_id='" . $_SESSION['USER_FB']['id'] . "', fb_access_token='" . $_SESSION['USER_FB']['access_token'] . "'" . $qury . "");
                }

                $_SESSION['USER_ID'] = $id;
                $_SESSION['USER_UNIQ_ID'] = $uniq_id;
                $_SESSION['USER_TYPE'] = $type;
//$_SESSION['LAST_LOGGED_IN'] = $last_login['created'];
//echo $_SESSION['VISITED_PAGE']; //exit;
                if (isset($_SESSION['VISITED_PAGE']) && $_SESSION['VISITED_PAGE'] && !strstr($_SESSION['VISITED_PAGE'], "admin")) {
//echo DOMAIN.$_SESSION['VISITED_PAGE']; exit;
                    header("location:" . DOMAIN . $_SESSION['VISITED_PAGE']);
                } else {
                    header("location:" . HTTP_ROOT . "index");
                }
            }
        } else {
            return $err;
        }
    }

    function validateFileExt($ext) {
        $extList = array("bat", "com", "cpl", "dll", "exe", "msi", "msp", "pif", "shs", "sys", "cgi", "reg", "bin", "torrent", "yps", "scr", "com", "pif", "chm", "cmd", "cpl", "crt", "hlp", "hta", "inf", "ins", "isp", "jse?", "lnk", "mdb", "ms", "pcd", "pif", "scr", "sct", "shs", "vb", "ws", "vbs");

        $ext = strtolower($ext);
        if (!in_array($ext, $extList)) {
            return "success";
        } else {
            return "." . $ext;
        }
    }

    function dateFormat($date, $type = 0) {
        if ($date && !strstr($date, "0000-00-00")) {
            $checkDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date, "date");
            $date = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date, "datetime");
            $curdate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], CURDT, "datetime");

            $curdate = date("Y-m-d", strtotime($curdate));
            $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));
            $tomorrow = date("Y-m-d", strtotime($curdate . "+1 days"));

            if ($checkDate == $curdate) {
                $dt = "Today";
            } elseif ($checkDate == $yesterday) {
                $dt = "Yesterday";
            } elseif ($checkDate == $tomorrow) {
                $dt = "Tomorrow";
            } else {
                $dt = date("jS M Y", strtotime($date));
            }
            if ($type == 2) {
                return $dt . " at " . date("g:i a", strtotime($date));
            } elseif ($type == 1) {
                return "<span style='display:none;'>" . strtotime($date) . "</span>" . $dt . " at " . date("g:i a", strtotime($date));
            } else {
                $date = date("Y-m-d", strtotime($date));
                return "<span style='display:none;'>" . strtotime($date) . "</span>" . $dt;
            }
        } else {
            return "";
        }
    }

    function dateFormat1($date, $type = 0) {
        $dt = date("M d, Y G:i:s", strtotime($date));
        return $dt;
    }

    function daysLeft($created, $curdate, $duration) {
        $created = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $created, "datetime");
        $curdate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $curdate, "datetime");

        $nextdate = date("Y-m-d H:i:s", strtotime($created . "+" . $duration . " days"));

        if (strtotime($nextdate) > strtotime($curdate)) {
            $diff = abs(strtotime($nextdate) - strtotime($created));

            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            if (!$months) {
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            } else {
                $days = $months * 30;
            }
        } else {
            $days = 0;
        }
        return $days;
    }

    function lastMonth($duration) {
        $curDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], CURDT, "datetime");
        $lastDate = date("Y-m-d H:i:s", strtotime($curDate . "-" . $duration . " months"));
        return $lastDate;
    }

    function nextMonthSubscription($date, $months) {
        $date = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date, "datetime");
        $nextDate = date("Y-m-d H:i:s", strtotime($date . "+" . $months . " months"));
        return dateFormat($nextDate);
    }

    function dueDate($date, $days) {
        $date = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date, "datetime");
        $date = date("Y-m-d H:i:s", strtotime($date . "+" . $days . " days"));
        return dateFormat($date);
    }

    function getCityName($country_id, $city_id) {
        $city = "";
        if ($country_id == 14 || $country_id == 178) {
            $getcntry = mysql_fetch_assoc(mysql_query("SELECT code FROM " . COUNTRIES . " WHERE id='" . $country_id . "'"));
            $getCity = mysql_fetch_array(mysql_query("SELECT name FROM city_subrub_" . strtolower($getcntry['code']) . " WHERE id='" . $city_id . "'"));
            $city = $getCity['name'];
        } else {
            $getCity = mysql_fetch_array(mysql_query("SELECT name FROM cities WHERE id='" . $city_id . "'"));
            $city = $getCity['name'];
        }
        return $city;
    }

    function formatMonth($value) {
        if ($value == 1) {
            return "Month";
        } elseif ($value < 12) {
            return $value . " Months";
        } else {
            $mnth = $value % 12;

            $yr = floor($value / 12);
            if ($mnth) {
                $yr = floor($value / 12);
                return $yr . " Year" . " " . $mnth . " Month";
            } else {
                return $yr . " Year";
            }
        }
    }

    function getLastSub($uid) {
        $getSub = mysql_fetch_assoc(mysql_query("SELECT * FROM " . USER_SUBSCRIPTIONS . " WHERE user_id='" . $uid . "' ORDER BY id DESC LIMIT 0,1"));
        if (!$getSub['id']) {
            $getSub = mysql_fetch_assoc(mysql_query("SELECT * FROM subscriptions WHERE id='1'"));
        }
        return $getSub;
    }

/////////   Showing date difference in 5days 10 hour format
    function hourDifference($endDate) {
        $endDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $endDate, "datetime");
        $Today = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], CURDT, "datetime");

        $to_time = strtotime($endDate);
        $from_time = strtotime($Today);
        $hourDiff = round(abs($to_time - $from_time) / 3600, 0);
        if ($endDate <= $Today) {
            return "0 ?µ??e? 0 ??e?";
        }
        if ($hourDiff >= 24) {
            $dayDiff = floor($hourDiff / 24);
            $hour = floor($hourDiff % 24);
            return $dayDiff . " ?µ??e? " . $hour . " ??e?";
        } else {
            return $hourDiff . " ??e?";
        }
    }

    function hourDifference1($endDate) {
        $endDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $endDate, "datetime");
        $Today = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], CURDT, "datetime");

        $to_time = strtotime($endDate);
        $from_time = strtotime($Today);
        if ($endDate >= $Today) {
            $hourDiff = round(abs($to_time - $from_time) / 3600, 0);
            return $hourDiff;
        }
    }

    function hourDiff($created, $type, $type1 = 0) { //echo $created."<br/>".$type."<br/>".$type1; exit();
        $created = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $created, "datetime");
        $Today = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], CURDT, "datetime");

        if ($type1) {
            $endDate = date('Y-m-d H:i:s', strtotime($created . " +" . $type1 . "hours"));
        }
        if ($type == 'Week') {
            $days = 7;
        } else if ($type == 'Months') {
            $days = 30;
        } else if ($type == 'Months') {
            $days = 30;
        } else if ($type == '2 Months') {
            $days = 60;
        } else {
            $days = $type;
        }

        if ($days) {
            $endDate = date("Y-m-d H:i:s", strtotime($created . "+" . $days . " days"));
        }
        $to_time = strtotime($endDate);
        $from_time = strtotime($Today);

        if ($endDate <= $Today) {
            return "0 ?µ??e? 0 ??e?";
        }
        if ($endDate > $Today) {
            $hourDiff = round(abs($to_time - $from_time) / 3600, 0);
            if ($hourDiff >= 24) {
                $dayDiff = floor($hourDiff / 24);
                $hour = floor($hourDiff % 24);
                return $dayDiff . " ?µ??e? " . $hour . " ??e?";
            } else {
                return $hourDiff . " ??e?";
            }
        }
    }

    function projectEnddate111($created, $days) {
        $created = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $created, "datetime");

        if ($days) {
            return date("Y-m-d", strtotime($created . "+" . $days . " ?µ??e?"));
        }
    }

    function projectStartDate($created) {
        $startDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $created, "datetime");
        return dateFormat($startDate);
    }

    function projectEnddate($enddate) {
        $endDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $enddate, "datetime");
        return dateFormat($endDate);
    }

    function getLatLng($add) {
        $lat = "";
        $lng = "";
        try {
            $page = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?sensor=true&address=" . urlencode($add));
            $data = json_decode($page);

            $geometry = "";
            foreach ($data->results as $fadd) {
                if ($fadd->geometry) {
                    $geometry = $fadd->geometry;
                }
            }
            if ($geometry->location->lat) {
                $lat = $geometry->location->lat;
            }
            if ($geometry->location->lng) {
                $lng = $geometry->location->lng;
            }
            if ($lat && $lng) {
                return $lat . "," . $lng;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function formatedAwardedMsg($msg, $name, $project) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $name, $msg);
        }
        if (strstr($msg, "[PROJECT]")) {
            $msg = str_replace("[PROJECT]", $project, $msg);
        }
        return $msg;
    }

    function formatedBidMsg($msg, $name, $project) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $name, $msg);
        }
        if (strstr($msg, "[PROJECT]")) {
            $msg = str_replace("[PROJECT]", $project, $msg);
        }
        return $msg;
    }

    function formatedAcceptAwardMsg($msg, $name, $project, $link) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $name, $msg);
        }
        if (strstr($msg, "[PROJECT]")) {
            $msg = str_replace("[PROJECT]", $project, $msg);
        }
        if (strstr($msg, "[here]")) {
            $msg = str_replace("[here]", $link, $msg);
        }
        return $msg;
    }

    function formatedBidPostMsg($msg, $username, $project_name, $bid_ammount, $days_complete, $description) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $username, $msg);
        }
        if (strstr($msg, "[PROJECT_NAME]")) {
            $msg = str_replace("[PROJECT_NAME]", $project_name, $msg);
        }
        if (strstr($msg, "[COMPLETE_DAYS]")) {
            $msg = str_replace("[COMPLETE_DAYS]", $days_complete, $msg);
        }
        if (strstr($msg, "[BID_AMOUNT]")) {
            $msg = str_replace("[BID_AMOUNT]", $bid_ammount, $msg);
        }
        if (strstr($msg, "[BID_DETAILS]")) {
            $msg = str_replace("[BID_DETAILS]", $description, $msg);
        }
        return $msg;
    }

    function formatedPMBMsg($msg, $fname, $msg1) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $fname, $msg);
        }
        if (strstr($msg, "[LINK]")) {

            $link = "<a href='" . HTTP_ROOT . "message.php' style='background:#009CDD;padding:5px 10px;color:#FFFFFF;text-decoration:none;border-radius:5px 5px 5px 5px;-moz-border-radius:5px 5px 5px 5px;-webkit-border-radius:5px 5px 5px 5px;font-size:14px;font-weight:bold;border:1px solid #05719F;'>Go to Choukos message box</a>";
            $msg = str_replace("[LINK]", $link, $msg);
        }
        if (strstr($msg, "[MESSAGE]")) {
            $msg = str_replace("[MESSAGE]", $msg1, $msg);
        }
        return $msg;
    }

    function onlyYear($created) {
        $created = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $created, "datetime");
        return date('Y', strtotime($created));
    }

    function formatedInvite($msg, $name, $link, $project) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $name, $msg);
        }
        if (strstr($msg, "[LINK]")) {
            $link = "<a href=" . $link . " style='background:#009CDD;padding:5px 10px;color:#FFFFFF;text-decoration:none;border-radius:5px 5px 5px 5px;-moz-border-radius:5px 5px 5px 5px;-webkit-border-radius:5px 5px 5px 5px;font-size:14px;font-weight:bold;border:1px solid #05719F;'>Click to Bid</a>";
            $msg = str_replace("[LINK]", $link, $msg);
        }
        if (strstr($msg, "[PROJECT]")) {
            $msg = str_replace("[PROJECT]", $project, $msg);
        }
        return $msg;
    }

    

    function formatSizeUnits($bytes) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
        return $bytes;
    }

    function mynl2br($text) {
        return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
    }

    function formatedContactMsg($msg, $message) {
        if (strstr($msg, "[MESSAGE]")) {
            $msg = str_replace("[MESSAGE]", $message, $msg);
        }
        return $msg;
    }

    function formatedAuctionWin($msg, $name, $seat, $doubloonz, $seat_price) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $name, $msg);
        }
        if (strstr($msg, "[SEAT]")) {
            $msg = str_replace("[SEAT]", $seat, $msg);
        }
        if (strstr($msg, "[PROJECT]")) {
            $msg = str_replace("[PROJECT]", $project, $msg);
        }
        return $msg;
    }

    function countryCityFromIP($ipAddr) {
        $url = "http://api.ipinfodb.com/v3/ip-city/?key=5cfaab6c5af420b7b0f88d289571b990763e37b66761b2f053246f9db07ca913&ip=$ipAddr&format=json";
        $d = file_get_contents($url);
        return json_decode($d, true);
    }

    function exchangePrice($value, $currency_code) {
//echo $currency_code;
        $url = "http://openexchangerates.org/api/latest.json?app_id=b683e8842e124c03be2dd7720a23ae3f";
        $d = file_get_contents($url);
        $convertPrice = json_decode($d, true);
//echo $convertPrice['rates'][$currency_code]; exit;
        return number_format($value / $convertPrice['rates'][$currency_code], 2);
    }

    function formatedFpMsgdeba($msg, $name, $username, $password, $link) {
        if (strstr($msg, "[NAME]")) {
            $msg = str_replace("[NAME]", $name, $msg);
        }
        if (strstr($msg, "[USERNAME]")) {
            $msg = str_replace("[USERNAME]", $username, $msg);
        }
        if (strstr($msg, "[PASSWORD]")) {
            $msg = str_replace("[PASSWORD]", $password, $msg);
        }
        if (strstr($msg, "[LINK]")) {
            $msg = str_replace("[LINK]", $link, $msg);
        }
        return $msg;
    }

    function devdbdate($value) {
        $value = date("Y-m-d", strtotime($value));
        return $value;
    }

    function dateFormat12($date, $type = 0) {
        $dt = date("M d, Y ", strtotime($date));
        return $dt;
    }

    function dateyear($date, $type = 0) {
        $dt = date("Y ", strtotime($date));
        return $dt;
    }

    function datemonth($date, $type = 0) {
        $dt = date("M", strtotime($date));
        return $dt;
    }

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function message($date, $type = 2) {
        if ($date && !strstr($date, "0000")) {
            $checkDate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date, "date");
            $date = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], $date, "datetime");
            $curdate = GetDateTime($_SESSION['TIMEZONE_ID'], $_SESSION['TIMEZONE_GMT_OFFSET'], $_SESSION['TIMEZONE_DST_OFFSET'], CURDT, "datetime");

            $curdate = date("Y-m-d", strtotime($curdate));
            $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));
            $tomorrow = date("Y-m-d", strtotime($curdate . "+1 days"));

            if ($checkDate == $curdate) {
                $dt = "Today";
            } elseif ($checkDate == $yesterday) {
                $dt = "Yesterday";
            } elseif ($checkDate == $tomorrow) {
                $dt = "Tomorrow";
            } else {
                $dt = date("jS M Y", strtotime($date));
            }
            if ($type == 2) {
                return date("g:i a ", strtotime($date));
            } elseif ($type == 1) {
                return "<span style='display:none;'>" . strtotime($date) . "</span>" . $dt . " at " . date("g:i a", strtotime($date));
            } else {
                $date = date("Y-m-d", strtotime($date));
                return "<span style='display:none;'>" . strtotime($date) . "</span>" . $dt;
            }
        } else {
            return "";
        }
    }

}
