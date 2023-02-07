<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\GalleryFile;
use App\Models\GalleryFolder;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Services\GalleryFileServices;
use App\Services\GalleryFolderServices;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $galleryFolder, $galleryFile;
    protected $dirView;
    protected $user, $menuUser, $permissionMenu, $route;
    public function __construct(GalleryFolderServices $services, GalleryFileServices $fileServices){
        $this->galleryFolder = $services;
        $this->galleryFile = $fileServices;
        $this->dirView = 'gallery'; //gallery - file manager
        $this->middleware('auth:web');
        $this->route = 'gallery';
        $this->middleware(function($request, $next){
            $this->userMenu = Auth::user()->getMenu();
            $permission = Auth::user()->checkPermissionMenu($request->path(), $this->userMenu);
            if(!$permission['access']){
                abort(403);
            }
            $this->permissionMenu = $permission['permission'];
            return $next($request);
        });

    }

    public function index(Request $request){
        $data['menu'] = Menu::menu();
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['view_folder'] = true;
        $data['view_file'] = false;
        $data['view_file_folder'] = false;
        //check super user
        $super = Auth::user()->superRole();
        if(!$super){
            //filter by created_by
            // $request->created_by = Auth::user()->id;
        }
        $data['superUser'] = $super;
        if(!in_array('moderasi', $data['permission'])){
            $request->is_public = 1; //only published
        }

        $data['table'] = $this->galleryFolder->getAllWithFilter($request, 1, 1);
        $filterFile = $request;
        $filterFile->nofolder = true;
        // $data['fileNoFolder'] = $this->galleryFile->getAllWithFilter($filterFile, 1, 1);
        $data['fileNoFolder'] = [];
        return view($this->dirView.'.gallery-media', $data);
    }

    public function filter(Request $request){
        $data['menu'] = Menu::menu();
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        if($request->type_file){
            $data['view_folder'] = false;
        }else{
            $data['view_folder'] = true;
        }
        if($request->is_important){
            $data['view_file'] = false;
        }else{
            $data['view_file'] = false;
        }
        $data['view_file_folder'] = false;
        //check super user
        $super = Auth::user()->superRole();
        if(!$super){
            //filter by created_by
            // $request->created_by = Auth::user()->id;
        }
        $data['superUser'] = $super;
        $data['table'] = $this->galleryFolder->getAllWithFilter($request, 1, 1);

        $filterFile = $request;
        // $data['fileNoFolder'] = $this->galleryFile->getAllWithFilter($filterFile, 1, 1);
        $data['fileNoFolder'] = [];
        if(isset($request->type_file)){
            $data['view_file'] = true;
            $data['view_folder'] = false;
            $data['fileNoFolder'] = $this->galleryFile->getAllWithFilter($filterFile, 1, 1);
        }
        return view($this->dirView.'.gallery-media', $data);
    }

    public function detailFolder(Request $request){

        $data['menu'] = Menu::menu();
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['view_folder'] = false;
        $data['view_file'] = false;
        $data['view_file_folder'] = true;
        $data['folder_id'] = $request->id;
        //update size folder
        if(!in_array('moderasi', $data['permission'])){
            $request->is_public = 1; //only published
        }
        $this->galleryFolder->updateSizeAndViewerFolder($request->id);

        //check super user
        $super = Auth::user()->superRole();
        if(!$super){
            //filter by created_by
            // $request->created_by = Auth::user()->id;
        }
        $data['superUser'] = $super;
        $data['table'] = $this->galleryFolder->getAllWithFilter($request, 1, 1)->first();
        if(!in_array('moderasi', $data['permission'])){
            $data['fileFolder'] = $data['table']->hasFiles->where('is_public', 1);
        }else{
            $data['fileFolder'] = $data['table']->hasFiles;
        }
        return view($this->dirView.'.gallery-media', $data);
    }

    public function info(Request $request){
        try{
            if(isset($request->type) && $request->type == 'folder'){
                //get services
                $folder = $this->galleryFolder->getById($request->idfile)->first();
                $folder->type_gallery = 'folder';
                $folder->icon_view = '<img src="../../../app-assets/images/icons/onedrive.png" alt="file-icon" height="64">';
                $folder->size_view = convertSizeStorage($folder->size_folder);
                $folder->created_at_indo = customTanggal($folder->created_at, 'd M Y h:i');
                $folder->updated_at_indo = customTanggal($folder->updated_at, 'd M Y h:i');
                return response()->json($folder);
            }
            if(isset($request->type) && $request->type == 'file'){
                //update viewer file
                $this->galleryFile->updateViewerFile($request->idfile);
                //get services
                $folder = $this->galleryFile->getById($request->idfile)->first();
                $folder->type_gallery = 'file';
                $folder->name_folder = $folder->name_file;
                if($folder->type_file == 'image'){
                    $folder->icon_view = '<img src="'.asset($folder->path_file).'" alt="file-icon" class="img-fluid" height="64">';
                }else{
                    $folder->icon_view = '<img src="../../../app-assets/images/icons/'.$folder->ext_file.'.png" alt="file-icon" height="64">';
                }
                $folder->size_view = convertSizeStorage($folder->size_file);
                $folder->total_viewer = $folder->total_viewer_file;
                $folder->created_at_indo = customTanggal($folder->created_at, 'd M Y h:i');
                $folder->updated_at_indo = customTanggal($folder->updated_at, 'd M Y h:i');
                $folder->description_folder = $folder->description_file;

                return response()->json($folder);
            }
            return response()->json(['error' => 'data not found'], 404);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try{
            //store to model GalleryFolder
            \DB::beginTransaction();

            if(empty($request->id)){
                $galleryFolder = new GalleryFolder();
            }else{
                $galleryFolder = GalleryFolder::find($request->id);
            }
            $galleryFolder->id = generate_id();
            $galleryFolder->name_folder = $request->name_folder;
            $galleryFolder->description_folder = $request->description_folder;
            $galleryFolder->size_folder = 0;
            $galleryFolder->is_public = 0;
            $galleryFolder->is_important = 0;
            $galleryFolder->total_viewer = 0;
            $galleryFolder->deleted_at = null;
            $galleryFolder->updated_at = null;
            $galleryFolder->created_by = Auth::user()->id;
            $galleryFolder->save();

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successfully Created Folder'
            ]);

        }catch(\ErrorException $e){
            \DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function upload(Request $request){
        try{
            //store to model GalleryFile with multiple file
            \DB::beginTransaction();
            $folderId = 'uncategorized';
            if(!empty($request->folder_id)){
                $files  = multipleUploadGallery($request, 'file', 'gallery/'.$request->folder_id, true);
                $folderId = $request->folder_id;
            }else{
                $files  = multipleUploadGallery($request, 'file', 'gallery/uncategorized', true);
            }
            $galleryFile = new GalleryFile();
            $galleryFile->id = generate_id();
            $galleryFile->gallery_folder_id = $folderId;
            $galleryFile->name_file = str_replace("%","-",$files['name']);
            $galleryFile->path_file = $files['path'];
            $galleryFile->description_file = null;
            $galleryFile->size_file = $files['size'];
            $galleryFile->type_file = $files['type'];
            $galleryFile->ext_file = $files['extension'];
            $galleryFile->total_viewer_file = 0;
            $galleryFile->is_public = 0;
            $galleryFile->created_at = now();
            $galleryFile->deleted_at = null;
            $galleryFile->deleted_by = null;
            $galleryFile->created_by = Auth::user()->id;
            $galleryFile->save();

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully Created File'
            ]);

        }catch(\ErrorException $e){
            \DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request){
        try{
            //update to gallery_folder
            if($request->type_gallery == 'folder'){
                $update = GalleryFolder::findOrFail($request->id_gallery);
                $update->name_folder = $request->name;
                $update->description_folder = $request->description;
                $update->is_public = ($request->is_public == 'on') ? 1 : 0;
                $update->is_important = ($request->is_important == 'on') ? 1 : 0;
                $update->updated_at = now();
                $update->updated_by = Auth::user()->id;
                $update->save();

                return redirect()->back()->with('success', 'Successfully Updated Folder');
            }
            if($request->type_gallery == 'file'){
                $update = GalleryFile::findOrFail($request->id_gallery);
                $update->name_file = str_replace("%","-",$request->name);
                $update->description_file = $request->description;
                $update->is_public = ($request->is_public == 'on') ? 1 : 0;
                $update->updated_at = now();
                $update->updated_by = Auth::user()->id;
                $update->save();

                return redirect()->back()->with('success', 'Successfully Updated File');
            }

        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if($request->type == 'folder'){
            $folder = GalleryFolder::findOrFail($id);
            $folder->deleted_at = now();
            $folder->deleted_by = Auth::user()->id;
            $folder->save();
            return redirect()->back()->with('success', 'Successfully Deleted Folder');
        }
        if($request->type == 'file'){
            $file = GalleryFile::findOrFail($id);
            $file->deleted_at = now();
            $file->deleted_by = Auth::user()->id;
            $file->save();
            return redirect()->back()->with('success', 'Successfully Deleted File');
        }
        return redirect()->back()->with('error', 'Successfully Deleted File');
    }

}
