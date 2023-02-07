<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    public $incrementing = false;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'name',
        'email',
        'active',
        'password',
        'expo_token',
        'is_loggedin_mobile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roleUser()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }
    public function superRole()
    {
        $superRole = Auth::user()->roleUser()->get()->pluck('role_id')->toArray();
        $paramsSuper = GeneralParams::where('slug', 'like', "%role-super%")->first();
        $isSuper = false;
        if (!empty($paramsSuper)) {
            $value = json_decode($paramsSuper->name, 1);
            foreach ($value as $idRole) {
                if (in_array($idRole, $superRole)) {
                    $isSuper = true;
                }
            }
        }
        return $isSuper;
    }
    public static function userAssignRole($idUser)
    {
        $idRoleDefault = GeneralParams::where('slug', 'like', "%default-role%")->first()->name;
        $cek = UserRole::where('user_id', $idUser)->first();
        if (empty($cek)) {
            UserRole::create([
                'id' => generate_id(),
                'user_id' => $idUser,
                'role_id' => $idRoleDefault,
                'active' => 1,
                'created_by' => $idUser,
                'created_at' => now(),
                'updated_by' => $idUser,
                'updated_at' => now()
            ]);
        }
    }
    public function getMenu()
    {
        return Menu::menu();
    }
    public function checkPermissionMenu($path, $arrayMenu)
    {
        $access = false;
        //check path with menu and submenu, if not exist return alert and redirect back
        $arrayPermission = [];
        foreach ($arrayMenu as $menu) {
            if (str_contains('/' . $path, $menu['menu_url'])) {
                $access = true;
                $arrayPermission = $menu['permission'];
                break;
            }
            if (isset($menu['submenu'])) {
                foreach ($menu['submenu'] as $submenu) {
                    if (str_contains('/' . $path, $submenu['menu_url'])) {
                        $access = true;
                        $arrayPermission = $submenu['permission'];
                        break;
                    }
                }
            }
        }
        if ($access == false) {
            //popup alert javascript
            echo '<script>alert("You do not have permission to access this page");</script>';
            //echo history back
            echo '<script>history.back();</script>';
        }
        return ['access' => $access, 'permission' => $arrayPermission];
    }

    //user has profile
    public function profile()
    {
        error_reporting(0);
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }
}
