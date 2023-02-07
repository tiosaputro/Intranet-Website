<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Menu extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "menu"; //menu / modul

    protected $fillable = [
        'id',
        'menu_name',
        'slug',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'active',
        'is_parent',
        'order','url', 'icon','hide_mobile'
    ];

    public static function menu(){
        $dataMenu = array(
            ["menu" => "Home","url" => '/dashboard', "icon" => 'Home', "submenu" => [], "is_login" => false ],
            [ "menu" => "Company", "url" => '#', "icon" => 'home', "is_login" => false, "submenu" =>  [
                    [ "sub_menu" => 'Vision & Mision' , "url" => '/vision-mision', "sub_icon" => 'link-2'],
                    [ "sub_menu" => 'Organization Structure' , "url" => '/organization-structure', "sub_icon" => 'link-2'],
                    [ "sub_menu" => 'Info & News' , "url" => '/info-emp', "sub_icon" => 'link-2'],
                    // [ "sub_menu" => 'Policy & Procedures' , "url" => '/policy', "sub_icon" => 'link-2'],
                    // [ "sub_menu" => 'Forms' , "url" => '/forms', "sub_icon" => 'link-2'],
                    [ "sub_menu" => 'Library' , "url" => '/library', "sub_icon" => 'link-2'],
                    [ "sub_menu" => 'Calendar' , "url" => '/calendar', "sub_icon" => 'link-2'],
                ] //endsub
            ],//endmenu
            [ "menu" => "Community", "url" => '#', "icon" => 'command', "is_login" => false, "submenu" =>  [
                    [ "sub_menu" => 'Knowledge Sharing' , "url" => '/knowledges-sharing', "sub_icon" => 'aperture'],
                    [ "sub_menu" => 'Events & Media' , "url" => '/event', "sub_icon" => 'camera'],
                    [ "sub_menu" => 'Directory' , "url" => '/directory', "sub_icon" => 'folder'],
                    // [ "sub_menu" => 'Chat' , "url" => '/chat', "sub_icon" => 'message-circle'],
                ] //endsub
            ],//endmenu
            [ "menu" => "My EMP", "url" => '#', "icon" => 'home', "is_login" => false, "submenu" =>  [
                [ "sub_menu" => 'Vacation Request' , "url" => '/vacation-request', "sub_icon" => 'compass'],
                [ "sub_menu" => 'Payslip' , "url" => '/payslip', "sub_icon" => 'credit-card'],
                [ "sub_menu" => 'ICT Helpdesk' , "url" => '/ict', "sub_icon" => 'gitlab'],
                [ "sub_menu" => 'Onboarding' , "url" => '/boarding', "sub_icon" => 'clipboard'],
                [ "sub_menu" => 'FAQ' , "url" => '/faq', "sub_icon" => 'help-circle'],
                [ "sub_menu" => 'Linked Apps' , "url" => '/link-app', "sub_icon" => 'Link'],
                [ "sub_menu" => 'Learning' , "url" => '/learning', "sub_icon" => 'database'],
                [ "sub_menu" => 'My Tasks' , "url" => '/my-task', "sub_icon" => 'edit'],
            ] //endsub
        ],//endmenu
        [ "menu" => "Dashboard", "url" => '#', "icon" => 'home', "is_login" => false, "submenu" =>  [
            [ "sub_menu" => 'Production Daily', "url" => '/management-bod', "sub_icon" => 'Activity'],
            [ "sub_menu" => 'Weekly Chart', "url" => '/management-weekly', "sub_icon" => 'Bar-Chart'],
            [ "sub_menu" => 'Yearly Chart', "url" => '/management-yearly', "sub_icon" => 'Pie-Chart'],
            ] //endsub
        ],//endmenu
        [ "menu" => "Admin Management", "url" => '#', "icon" => 'Users', "is_login" => true, "submenu" => [
            [ "sub_menu" => 'User Management', "url" => '/backend/admin-users', "sub_icon" => 'Users'],
            [ "sub_menu" => 'Role Management', "url" => '/backend/role/get-list', "sub_icon" => 'User-Check'],
            [ "sub_menu" => 'Permission Management', "url" => '/backend/permission/get-list', "sub_icon" => 'Folder-Minus'],
            [ "sub_menu" => 'Modul/Menu Management', "url" => '/backend/menu/get-list', "sub_icon" => 'Menu'],
            [ "sub_menu" => 'Info & News Content', "url" => '/backend/management-content', "sub_icon" => 'bell'],
            [ "sub_menu" => 'Library', "url" => '/backend/management-library', "sub_icon" => 'file'],
            // [ "sub_menu" => 'Directory', "url" => '/backend/management-directory', "sub_icon" => 'folder'],
            // [ "sub_menu" => 'Emergency Contact', "url" => '/backend/management-emergency', "sub_icon" => 'phone'],
            // [ "sub_menu" => 'Gallery', "url" => '/backend/management-gallery', "sub_icon" => 'camera'],
            // [ "sub_menu" => 'Media Highlight', "url" => '/admin-media-highlight', "sub_icon" => 'Rss'],
            // [ "sub_menu" => 'Company Campaign', "url" => '/admin-company-campaign', "sub_icon" => 'Rss'],
            // [ "sub_menu" => 'Info EMP', "url" => '/admin-info-emp', "sub_icon" => 'Rss'],
            // [ "sub_menu" => 'Event', "url" => '/admin-event', "sub_icon" => 'calendar'],
            [ "sub_menu" => 'Knowledge Sharing', "url" => '/backend/management-knowledge-sharing', "sub_icon" => 'share']
           ]//endsub
        ]//endmenu
    );
    //get user role
    $idUser = Auth::user()->id;
    $roleUser = UserRole::select('role_id')->where('user_id', $idUser)->get()->toArray();
    $roleUser = collect($roleUser)->pluck('role_id')->toArray();
    $menuUser = [];
    if(!empty($roleUser)){
        //get role menu permission
        $rolePermission = RoleMenuPermission::whereIn('role_menu_permissions.role_id', $roleUser)
            ->select('role_menu_permissions.*', 'menu.slug as menu_slug', 'menu.menu_name as menu_name', 'menu.icon as menu_icon','menu.url as menu_url', 'menu.order as menu_order', 'menu.is_parent','menu.hide_mobile')
            ->join('menu', 'menu.id','role_menu_permissions.menu_id')
            ->get();
        $rolePermissionGet = $rolePermission->groupBy('menu_id');
        $menu = collect($rolePermissionGet)->map(function($row){
            $permission = [];
            foreach($row as $rows){
                $permission[] = $rows->permission_slug;
            }
            return [
                'menu_id' => $row[0]->menu_id,
                'menu_name' => $row[0]->menu_name,
                'menu_icon' => $row[0]->menu_icon,
                'menu_slug' => $row[0]->menu_slug,
                'menu_order' => $row[0]->menu_order,
                'menu_url' => $row[0]->menu_url,
                'menu_is_parent' => $row[0]->is_parent,
                'permission' => $permission,
                'hide_mobile' => $row[0]->hide_mobile
            ];
        });
        $roleMenu = $menu->values();
        $parent = collect($roleMenu)->where('menu_is_parent','#')->sortBy('menu_order');
        $subMenu = [];
        foreach($parent as $idx => $par){
            $menuUser[$idx] = $par;

            $subMenu = collect($roleMenu)->where('menu_is_parent',$par['menu_id'])->sortBy('menu_order')->toArray();
            //check is have child menu
            $childSubMenu = [];
            if(!empty($subMenu)){
                foreach($subMenu as $subIdx => $sub){
                    //check is have child menu
                    $childSubMenu = Menu::where('is_parent', $sub['menu_id'])->where('active', 1)->orderBy('order', 'asc')->get()->toArray();
                    $subMenu[$subIdx]['child'] = $childSubMenu;
                }
            }
            $menuUser[$idx]['haveChild'] = count($childSubMenu) > 0 ? true : false;
            $menuUser[$idx]['submenu'] = $subMenu;
        }
    }
        return $menuUser;
    } //end function
}
