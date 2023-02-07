<?php

use App\Models\Broadcast;
use App\Models\GalleryFile;
use App\Models\GeneralParams;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

//get extension file from path
if (!function_exists('getExtension')) {
    function getExtension($path)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        return $ext;
    }
}

//create function check extension image or file
if (!function_exists('checkImageOrFile')) {
    function checkImageOrFile($path)
    {
        $supported_image = array(
            'gif',
            'jpg',
            'jpeg',
            'png'
        );

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
        if (in_array($ext, $supported_image)) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('uploadImage')) {
    function uploadEditor($request, $modul)
    { //modul is directory
        if ($request->hasFile('upload')) {
            $modul = ($modul != 'undefined') ? $modul : 'file-content';
            //get filename with extension
            $fileNameWithExtension = $request->file('upload')->getClientOriginalName();
            //get filename without extension
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            //Upload File
            $request->file('upload')->storeAs('public/' . $modul . '/', $fileNameToStore);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum') ? $request->input('CKEditorFuncNum') : 0;
            if ($CKEditorFuncNum > 0) {
                $url = asset('storage/' . $modul . '/' . $fileNameToStore);
                $msg = 'Image successfully uploaded';
                $renderHtml = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                // Render HTML output
                @header('Content-type: text/html; charset=utf-8');
                echo $renderHtml;
            } else {
                $url = asset('storage/' . $modul . '/' . $fileNameToStore);
                $msg = 'Image successfully uploaded';
                $renderHtml = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                return response()->json([
                    'uploaded' => '1',
                    'fileName' => $fileNameToStore,
                    'url' => $url
                ]);
            }
        }
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($request)
    {
        $param = 'file';
        if ($request->hasFile($param)) {
            $fileNameWithExt = $request->file($param)->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file($param)->getClientOriginalExtension();
            $filenameSave = $filename . '_' . time() . '.' . $extension;
            $destinationPath = storage_path() . '/app/public/' . $request->category; // upload path
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $path = $request->file($param)->storeAs('public/' . $request->category, $filenameSave);
        } else {
            $path = null;
            $filenameSave = 'default.png';
        }
        if (!empty($path)) {
            $path = str_replace("public", "storage", $path);
        }
        return $path;
    }
}

if (!function_exists('uploadFileGeneral')) {
    function uploadFileGeneral($request, $param, $dirPath, $isMultiple = false)
    {
        if ($isMultiple) { //is multiple upload true
            $fileNameWithExt = $request->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->getClientOriginalExtension();
            $filenameSave = $filename . '_' . time() . '.' . $extension;
            $destinationPath = storage_path() . '/app/public/' . $dirPath; // upload path
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $path = $request->storeAs('public/' . $dirPath, $filenameSave);
        } else {
            if ($request->hasFile($param)) {
                $fileNameWithExt = $request->file($param)->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($param)->getClientOriginalExtension();
                $filenameSave = $filename . '_' . time() . '.' . $extension;
                $destinationPath = storage_path() . '/app/public/' . $dirPath; // upload path
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $path = $request->file($param)->storeAs('public/' . $dirPath, $filenameSave);
            } else {
                $path = null;
                $filenameSave = 'default.png';
            }
            if (!empty($path)) {
                $path = str_replace("public", "storage", $path);
            }
        }
        return $path;
    }
}

//create function for multiple upload
if (!function_exists('multipleUploadGallery')) {
    function multipleUploadGallery($request, $param, $dirPath)
    {
        $files = $request->file($param);
        $file_array = array();
        if ($request->hasFile($param)) {
            // foreach($files as $file){
            // $file_array[] = uploadFileGeneral($file, $param, $dirPath, true);
            $file = $request->file($param);
            $fileNameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filenameSave = str_replace("%","-",$filename) . '_' . time() . '.' . $extension;
            $destinationPath = storage_path() . '/app/public/' . $dirPath; // upload path
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $path = $file->storeAs('public/' . $dirPath, $filenameSave);
            if (!empty($path)) {
                $path = str_replace("public", "storage", $path);
                //assign to array
                $file_array = [
                    'name' => $filenameSave,
                    'path' => $path,
                    'type' => category_file($extension),
                    'size' => $file->getSize(),
                    'extension' => $extension
                ];
            }
            // }
        }
        return $file_array;
    }
}
//create function category extension file
if (!function_exists('category_file')) {
    function category_file($extension)
    {
        //category file = document, video, audio, image, arvhive
        $category = ''; //default
        $extension = strtolower($extension);
        if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'])) {
            $category = 'document';
        } elseif (in_array($extension, ['mp4', 'avi', 'mkv', 'mov', 'flv', 'wmv', 'mpg', 'mpeg', 'MP4','AVI','MKV','FLV','MWV','MPEG','MPG'])) {
            $category = 'video';
        } elseif (in_array($extension, ['mp3', 'wav', 'wma', 'ogg', 'flac'])) {
            $category = 'audio';
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
            $category = 'image';
        } elseif (in_array($extension, ['zip', 'rar', 'tar', 'gz', '7z'])) {
            $category = 'archive';
        }
        return $category;
    }
}

if (!function_exists('multipleUpload')) {
    function multipleUpload($request, $param, $dirPath)
    {
        $files = $request->file($param);
        $file_array = array();
        if ($request->hasFile($param)) {
            foreach ($files as $file) {
                $file_array[] = uploadFileGeneral($file, $param, $dirPath, true);
            }
        }
        return $file_array;
    }
}


if (!function_exists('customTanggal')) {
    function customTanggal($date, $date_format)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($date_format);
    }
}
if (!function_exists('generate_id')) {
    function generate_id()
    {
        return \Illuminate\Support\Str::random(10) . date('his');
    }
}
if (!function_exists('number_id')) {
    function number_id()
    {
        return rand(2, 10) . date('his');
    }
}
if (!function_exists('getAuth')) {
    function getAuth()
    {
        return Auth::user();
    }
}
function customHanyaTanggal($date, $date_format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function customImagePath($dir, $image_name)
{
    return public_path($dir . '/' . $image_name);
}

function humanDate($date)
{
    return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
}

function tanggalIndo($tanggal)
{
    if (empty($tanggal)) {
        return '-';
    }
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . bulanIndo($pecahkan[1]) . ' ' . $pecahkan[0];
}

function bulanIndo($i)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    return $bulan[(int)$i];
}

function subDayDate($time, $day)
{
    $date = $time->subDays($day);
    return $date;
}

function digit($digitNol, $nilai)
{
    $count = strlen($nilai);
    if ($digitNol == $count) {
        return $nilai;
    }
    $nol = '';
    for ($i = 1; $i < $digitNol; $i++) {
        $nol .= '0';
    }
    return $nol . '' . $nilai;
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = "" . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function checkValueExist($value, $array)
{ //check value exist in collection
    $exp = explode("_", $value);
    $menuId = $exp[0];
    $slugId = $exp[1];
    $exist = collect($array)->where('permission_slug', $slugId)->where('menu_id', $menuId)->first();
    if (!empty($exist)) {
        return true;
    } else {
        return false;
    }
}
//get menu
if (!function_exists('getMenu')) {
    function getMenu()
    {
        return App\Models\Menu::menu();
    }
}
if (!function_exists('getContents')) {
    function getContents($str, $startDelimiter, $endDelimiter)
    {
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $contents;
    }
}

if (!function_exists('popupImageCkeditor')) {
    function popupImageCkeditor($html)
    {
        $arrayContent = getContents($html, '<img ', ' />');
        if (empty($arrayContent)) {
            return $html;
        } else {

            foreach ($arrayContent as $val) {
                //check if words is find string height
                if (strpos($val, 'height') !== false) {
                    //get string src in img
                    $arraySrc = getContents($val, 'src="', '"');
                    if (!empty($arraySrc)) {
                        $src = $arraySrc[0];
                        $addStyle = '<a data-fancybox="gallery" data-src="' . $src . '"> <img alt="" ' . $val . " class='img-fluid card-img-top' data-link='" . $src . "' data-caption='" . $src . "' style='max-height:370px; max-width:100%; object-fit:cover;' /> </a>";
                        $html = str_replace('<img ' . $val . ' />', $addStyle, $html);
                    } else {
                        return $html;
                    }
                }
            }
        }
        return $html;
    }
}

if (!function_exists('bannerBroadcast')) {
    function bannerBroadcast($slug)
    {
        $banner = Broadcast::where('type', 'like', "%" . $slug . "%")
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!empty($banner)) {
            $foto = json_decode($banner->file_path);
            //check exist file
            if (!empty($foto)) {
                return str_replace('public', 'storage', $foto[0]);
            } else {
                return 'app-assets/images/banner/banner.png';
            }
        } else {
            return 'app-assets/images/banner/banner.png';
        }
    }
}

//create function convert number to size storage
if (!function_exists('convertSizeStorage')) {
    function convertSizeStorage($size)
    {
        $unit = array('B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}   //end function convert number to size storage

//create function coloring badge
if (!function_exists('colorStatusLibrary')) {
    function colorStatusLibrary($status)
    {
        //get array from general params
        $generalParams = GeneralParams::all();
        $statusDocColor = $generalParams->where('slug', 'document-status-color')->first();
        $statusDoc = $generalParams->where('slug', 'document-status')->first();

        if (empty($statusDocColor)) {
            return $status;
        }
        $arrayColor = json_decode($statusDocColor->toArray()['name'], 1);
        $arrayStatusDoc = json_decode($statusDoc->toArray()['name'], 1);
        $idx = array_search($status, $arrayStatusDoc);
        $color = $arrayColor[$idx];
        return '<span class="badge badge-default" style="background-color:' . $color . '">' . $status . '</span>';
    }
}   //end function coloring badge

//create function tanggal ldap parse
if (!function_exists('tanggalLdap')) {
    function tanggalLdap($tgl)
    {
        $tgl = str_replace('"', '', $tgl);
        $tgl = substr($tgl, 0, 4) . '-' . substr($tgl, 4, 2) . '-' . substr($tgl, 6, 2) . ' ' . substr($tgl, 8, 2) . ':' . substr($tgl, 10, 2) . ':' . substr($tgl, 12, 2);
        return $tgl;
    }
}   //end function tanggal ldap parse

if(!function_exists('timeLoadPage')){
    function timeLoadPage(){
        $executionTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        return round($executionTime, 3).' sec';
    }
}

if(!function_exists('tagging_user')){
    function tagging_user($idUser){ // tag user is array
        $user = User::whereIn('id',$idUser)->get();
        $tagging = '';
        if(!empty($user)){
            foreach($user as $val){
                $tagging .= '<span class="alert alert-warning mt-1 font-bold"><i data-feather="user"></i> '.$val->name.'</span> &nbsp;&nbsp;';
            }
        }
        return $tagging;
    }
}

//create function thumbnail gallery folder
if(!function_exists('thumbnail_gallery')){
    function thumbnail_gallery($galleryFolderId){ //gallery folder id
        $galleryFolder = GalleryFile::where('gallery_folder_id',$galleryFolderId)
        ->where('type_file','image')
        ->first();
        if(!empty($galleryFolder)){
            $foto = $galleryFolder->path_file;
            //check exist file
            if(!empty($foto)){
                return ['status' => true, 'path' => $foto];
            }else{
                return ['status' => false, 'path' => '<i data-feather="folder"></i>'];
            }
        }else{
            //icon
            return ['status' => false, 'path' => '<i data-feather="folder"></i>'];
        }
    }
}
