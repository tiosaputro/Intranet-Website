<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\BusinessUnit;
use App\Models\Dashboard;
use App\Models\GeneralParams;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\BudgetDashboard;
use App\Models\News;
use App\Services\DashboardServices;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class DashboardManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $dirView;
    protected $myServices;
    protected $user, $menuUser, $permissionMenu, $route;
    public function __construct(DashboardServices $services)
    {
        $this->middleware('auth');
        $this->dirView = 'dashboard-management';
        $this->myServices = $services;
        $this->route = 'backend/dashboard';
        $this->middleware(function ($request, $next) {
            $this->userMenu = Auth::user()->getMenu();
            $permission = Auth::user()->checkPermissionMenu($request->path(), $this->userMenu);
            if (!$permission['access']) {
                abort(403);
            }
            $this->permissionMenu = $permission['permission'];
            return $next($request);
        });
    }

    public function table(Request $request)
    {
        $data['menu'] = $this->menu();
        $data['loggedin'] = Auth::check() ? 1 : 0;
        $data['user'] = Auth::check() ? json_encode(Auth::user()) : json_encode(['loggedin' => 0]);
        return view('layout_web.blank-content', $data);
    }

    public function index(Request $request)
    {

        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        //check super user
        $super = Auth::user()->superRole();
        if (!$super) {
            //filter by created_by
            $request->created_by = Auth::user()->id;
        }
        $data['superUser'] = $super;
        $data['table'] = $this->myServices->getAllWithFilter($request, 1, 1);
        return view($this->dirView . '.index', $data);
    }


    public function add(Request $request)
    {
        //check input daily
        $check = Dashboard::whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')");
        //check input budget
        $checkBudget = BudgetDashboard::whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')");
        if (empty($check->first())) {
            $inputDaily = false;
        } else {
            $inputDaily = true;
        }
        if (empty($checkBudget->first())) {
            $inputBudget = true;
        } else {
            $inputBudget = false;
        }
        //data business unit
        $bu = BusinessUnit::all()->where('active', 1);
        $data['bu'] = $bu;
        //format mapping
        $prod = array();
        foreach ($bu as $row) {
            if (!$inputDaily) {
                $map = array(
                    'id' => $row->id,
                    'name' => $row->keterangan,
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_gas_boepd' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                    'budget_oil' => 0,
                    'budget_gas' => 0,
                    'budget_total' => 0,
                    'wi_gas_boepd' => 0,
                    'wi_mboepd' => 0,
                );
            } else {
                $rowDashboard = Dashboard::where('code', $row->id)
                    ->whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')")
                    ->first();
                $map = array(
                    'id' => $rowDashboard->code,
                    'name' => $row->keterangan,
                    'gros_oil' => (float) $rowDashboard->gross_oil_bopd,
                    'gros_sale' => (float) $rowDashboard->gross_gas_mmscfd,
                    'gros_gas_boepd' => (float) $rowDashboard->gross_gas_boepd,
                    'gros_total' => (float) $rowDashboard->gross_total_mboepd,
                    'wi_oil' => (float) $rowDashboard->wi_oil_bopd,
                    'wi_sale' => (float) $rowDashboard->wi_gas_mmscfd,
                    'wi_gas_boepd' => (float)$rowDashboard->wi_gas_boepd,
                    'wi_total' => (float) $rowDashboard->wi_total_mboepd,
                    'wi_mboepd' => (float) $rowDashboard->wi_mboepd,
                );
            }
            $prod[] = $map;
        }

        $dataProd = array(
            'tanggal_ending' => \Carbon\Carbon::now()->format('d M Y h:i:s'),
            'dataProduction' => $prod
        );
        $totalGross = collect($dataProd['dataProduction'])->sum('gros_total');
        $totalWi = collect($dataProd['dataProduction'])->sum('wi_total');
        $data['dummy'] = $dataProd;
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['year'] = $this->dummyYearBod();
        $data['totalGross'] = $totalGross;
        $data['totalWi'] = $totalWi;
        //data bussiness unit
        $data['bu'] = BusinessUnit::all();
        $data['date'] = now();
        $data['inputBudget'] = $inputBudget;
        return view($this->dirView . '.add-form', $data);
    }

    public function addBudget(Request $request)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        //data bussiness unit
        $data['bu'] = BusinessUnit::all()->where('active', 1);
        //check input daily
        $check = Dashboard::whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')");
        //check input budget
        $checkBudget = BudgetDashboard::whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')");
        if (empty($check->first())) {
            $inputDaily = false;
        } else {
            $inputDaily = true;
        }
        if (empty($checkBudget->first())) {
            $inputBudget = true;
        } else {
            $inputBudget = false;
        }
        $bu = $data['bu'];
        $prod = array();
        foreach ($bu as $row) {
            if ($inputBudget) {
                $map = array(
                    'id' => $row->id,
                    'name' => $row->keterangan,
                    'oil_bopd' => 0,
                    'gas_mmscfd' => 0,
                    'total_mboepd' => 0,
                    'wi_mboepd' => 0,
                );
            } else {
                $rowDashboard = BudgetDashboard::where('code', $row->id)
                    ->whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')")
                    ->first();
                $map = array(
                    'id' => $rowDashboard->code,
                    'name' => $row->keterangan,
                    'oil_bopd' => (float) $rowDashboard->oil_bopd,
                    'gas_mmscfd' => (float) $rowDashboard->gas_mmscfd,
                    'total_mboepd' => (float) $rowDashboard->total_mboepd,
                    'wi_mboepd' => (float) $rowDashboard->wi_mboepd,
                );
            }
            $prod[] = $map;
        }
        $dataProd = array(
            'tanggal_ending' => \Carbon\Carbon::now()->format('d M Y h:i:s'),
            'dataProduction' => $prod
        );
        $totalMboepd = collect($dataProd['dataProduction'])->sum('total_mboepd');
        $totalWi = collect($dataProd['dataProduction'])->sum('wi_mboepd');
        $data['dummy'] = $dataProd;
        $data['budgetMboepd'] = $totalMboepd;
        $data['budgetWi'] = $totalWi;
        $data['date'] = now();
        $data['inputDaily'] = $inputDaily;
        return view($this->dirView . '.add-form-budget', $data);
    }

    public function saveBudget(Request $request)
    {
        try {
            if (!empty($request->bu_id)) {
                foreach ($request->bu_id as $idx => $val) {
                    $data = array(
                        'code' => $val,
                        'oil_bopd' => $request->OIL_BOPD[$idx],
                        'gas_mmscfd' => $request->GAS_MMSCFD[$idx],
                        'total_mboepd' => $request->TOTAL_MBOEPD[$idx],
                        'wi_mboepd' => $request->WI_MBOEPD[$idx]
                    );
                    $date = date('Y-m-d');
                    if (isset($request->date)) {
                        $date = $request->date;
                    }

                    $check = BudgetDashboard::whereRaw("TRUNC(created_at) = to_date('" . $date . "')")->where('code', $val);
                    if (empty($check->first())) {
                        $inputDaily = false;
                    } else {
                        $inputDaily = true;
                    }
                    if (!$inputDaily) {
                        $data = array_merge($data, array('id' => generate_id()));
                        $data = array_merge($data, array('created_by' => Auth::user()->id));
                        if (isset($request->date) && !empty($request->date)) {
                            $data = array_merge($data, array('created_at' => $request->date . ' ' . date('H:i:s')));
                        }
                        $save = BudgetDashboard::create($data);
                    } else {
                        $data = array_merge($data, array('updated_by' => Auth::user()->id));
                        $data = array_merge($data, array('updated_at' => now()));
                        $save = BudgetDashboard::whereRaw("TRUNC(created_at) = to_date('" . $date . "')")
                            ->where('code', $val)
                            ->update($data);
                    }
                }
                //success
                return redirect()->back()->with('success', 'Data Budget has been updated');
            } else {
                //error
                return redirect()->back()->with('error', 'Ada kesalahan dalam input data');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveDaily(Request $request)
    {
        try {
            //parameter array : bu_id, GROSS_OIL_BOPD, GROSS_GAS_MMSCFD, GROSS_TOTAL_MBOEPD, WI_OIL_BOPD, WI_GAS_MMSCFD, WI_TOTAL_MBOEPD, WI_MBOEPD
            if (!empty($request->bu_id)) {
                foreach ($request->bu_id as $idx => $val) {
                    $data = array(
                        'code' => $val,
                        'gross_oil_bopd' => $request->GROSS_OIL_BOPD[$idx],
                        'gross_gas_mmscfd' => $request->GROSS_GAS_MMSCFD[$idx],
                        'gross_gas_boepd' => $request->GROSS_GAS_BOEPD[$idx],
                        'gross_total_mboepd' => $request->GROSS_TOTAL_MBOEPD[$idx],
                        'wi_oil_bopd' => $request->WI_OIL_BOPD[$idx],
                        'wi_gas_mmscfd' => $request->WI_GAS_MMSCFD[$idx],
                        'wi_gas_boepd' => $request->WI_GAS_BOEPD[$idx],
                        'wi_total_mboepd' => $request->WI_TOTAL_MBOEPD[$idx],
                        'wi_mboepd' => $request->WI_MBOEPD[$idx]
                    );
                    $date = date('Y-m-d');
                    if (isset($request->date)) {
                        $date = $request->date;
                    }

                    $check = Dashboard::whereRaw("TRUNC(created_at) = to_date('" . $date . "')")->where('code', $val);
                    if (empty($check->first())) {
                        $inputDaily = false;
                    } else {
                        $inputDaily = true;
                    }
                    if (!$inputDaily) {
                        $data = array_merge($data, array('id' => generate_id()));
                        $data = array_merge($data, array('created_by' => Auth::user()->id));
                        if (isset($request->date) && !empty($request->date)) {
                            $data = array_merge($data, array('created_at' => $request->date . ' ' . date('H:i:s')));
                        }
                        $save = Dashboard::create($data);
                    } else {
                        $data = array_merge($data, array('updated_by' => Auth::user()->id));
                        $data = array_merge($data, array('updated_at' => now()));
                        $save = Dashboard::whereRaw("TRUNC(created_at) = to_date('" . $date . "')")
                            ->where('code', $val)
                            ->update($data);
                    }
                }
                //success
                return redirect()->back()->with('success', 'Data Daily Production has been updated');
            } else {
                //error
                return redirect()->back()->with('error', 'Ada kesalahan dalam input data');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        //check input daily
        $check = Dashboard::whereRaw("TRUNC(created_at) = to_date('" . $request->date . "')");
        $bu = BusinessUnit::where('active', 1);
        if ($request->bu != null) {
            $bu->where('id', $request->bu);
            $check->where('code', $request->bu);
        }
        if (empty($check->first())) {
            $inputDaily = false;
        } else {
            $inputDaily = true;
        }
        //checkBudget
        $checkBudget = BudgetDashboard::whereRaw("TRUNC(created_at) = to_date('" . $request->date . "')");
        if (empty($checkBudget->first())) {
            $inputBudget = true;
        } else {
            $inputBudget = false;
        }
        $data['inputBudget'] = $inputBudget;
        //data business unit
        $data['bu'] = $bu->get();
        //format mapping
        $prod = array();
        $bu = $bu->get();
        foreach ($bu as $row) {
            if (!$inputDaily) {
                $map = array(
                    'id' => $row->id,
                    'name' => $row->keterangan,
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_gas_boepd' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                    'budget_oil' => 0,
                    'budget_gas' => 0,
                    'budget_total' => 0,
                    'wi_gas_boepd' => 0,
                    'wi_mboepd' => 0,
                );
            } else {
                $rowDashboard = Dashboard::where('code', $row->id);
                if (empty($request->date)) {
                    $rowDashboard->whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')");
                } else {
                    $rowDashboard->whereRaw("TRUNC(created_at) = to_date('" . $request->date . "')");
                }
                if (!empty($request->bu)) {
                    $rowDashboard->where('code', $request->bu);
                }
                $rowDashboard = $rowDashboard->first();
                $map = array(
                    'id' => $rowDashboard->code,
                    'name' => $row->keterangan,
                    'gros_oil' => (float) $rowDashboard->gross_oil_bopd,
                    'gros_sale' => (float) $rowDashboard->gross_gas_mmscfd,
                    'gros_gas_boepd' => (float) $rowDashboard->gross_gas_boepd,
                    'gros_total' => (float) $rowDashboard->gross_total_mboepd,
                    'wi_oil' => (float) $rowDashboard->wi_oil_bopd,
                    'wi_sale' => (float) $rowDashboard->wi_gas_mmscfd,
                    'wi_gas_boepd' => (float)$rowDashboard->wi_gas_boepd,
                    'wi_total' => (float) $rowDashboard->wi_total_mboepd,
                    'wi_mboepd' => (float) $rowDashboard->wi_mboepd
                );
            }
            $prod[] = $map;
        }
        $dataProd = array(
            'tanggal_ending' => \Carbon\Carbon::now()->format('d M Y h:i:s'),
            'dataProduction' => $prod
        );
        $data['dummy'] = $dataProd;
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['year'] = $this->dummyYearBod();
        //data bussiness unit
        $data['bu'] = BusinessUnit::all();
        $data['filterDate'] = $request->date;
        $data['filterBu'] = $request->bu;
        return view($this->dirView . '.update-form', $data);
    }

    public function filterBudget(Request $request)
    {
        //check input daily
        $check = BudgetDashboard::whereRaw("TRUNC(created_at) = to_date('" . $request->date . "')");
        $bu = BusinessUnit::where('active', 1);
        if ($request->bu != null) {
            $bu->where('id', $request->bu);
            $check->where('code', $request->bu);
        }
        if (empty($check->first())) {
            $inputDaily = true;
        } else {
            $inputDaily = false;
        }
        //data business unit
        $data['bu'] = $bu->get();
        //format mapping
        $prod = array();
        $bu = $bu->get();
        foreach ($bu as $row) {
            if ($inputDaily) {
                $map = array(
                    'id' => $row->id,
                    'name' => $row->keterangan,
                    'oil_bopd' => 0,
                    'gas_mmscfd' => 0,
                    'total_mboepd' => 0,
                    'wi_mboepd' => 0,
                );
            } else {
                $rowDashboard = BudgetDashboard::where('code', $row->id)
                    ->whereRaw("TRUNC(created_at) = to_date('" . date('Y-m-d') . "')")
                    ->first();
                $map = array(
                    'id' => $rowDashboard->code,
                    'name' => $row->keterangan,
                    'oil_bopd' => (float) $rowDashboard->oil_bopd,
                    'gas_mmscfd' => (float) $rowDashboard->gas_mmscfd,
                    'total_mboepd' => (float) $rowDashboard->total_mboepd,
                    'wi_mboepd' => (float) $rowDashboard->wi_mboepd,
                );
            }
            $prod[] = $map;
        }
        $dataProd = array(
            'tanggal_ending' => \Carbon\Carbon::now()->format('d M Y h:i:s'),
            'dataProduction' => $prod
        );
        $totalMboepd = collect($dataProd['dataProduction'])->sum('total_mboepd');
        $totalWi = collect($dataProd['dataProduction'])->sum('wi_mboepd');
        $data['dummy'] = $dataProd;
        $data['budgetMboepd'] = $totalMboepd;
        $data['budgetWi'] = $totalWi;
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        //data bussiness unit
        $data['bu'] = BusinessUnit::all();
        $data['filterDate'] = $request->date;
        $data['filterBu'] = $request->bu;
        $data['inputDaily'] = $inputDaily;
        return view($this->dirView . '.update-form-budget', $data);
    }

    private function getDataDashboard($typeDate)
    {
        $bu = BusinessUnit::where('active', 1)->get();
        $dataAll = array();
        $prod = array();
        $prodJoin = array();
        $empNon = array();
        $params = GeneralParams::getArray('dashboard-bu');
        foreach ($bu as $key => $row) {
            $rowDashboard = Dashboard::where('code', $row->id);
            $rowDashboard->selectRaw("
            SUM(GROSS_OIL_BOPD) as GROSS_OIL_BOPD,
 	        SUM(GROSS_GAS_MMSCFD) as GROSS_GAS_MMSCFD,
 	        SUM(GROSS_GAS_BOEPD) as GROSS_GAS_BOEPD,
	        SUM(GROSS_TOTAL_MBOEPD) as GROSS_TOTAL_MBOEPD,
	        SUM(WI_OIL_BOPD) as WI_OIL_BOPD,
	        SUM(WI_GAS_MMSCFD) as WI_GAS_MMSCFD,
	        SUM(WI_GAS_BOEPD) as WI_GAS_BOEPD,
	        SUM(WI_TOTAL_MBOEPD) as WI_TOTAL_MBOEPD,
	        SUM(WI_MBOEPD) as WI_MBOEPD");

            $budgetDashboard = BudgetDashboard::where('code', $row->id);
            $budgetDashboard->selectRaw("
            SUM(OIL_BOPD) as OIL_BOPD,
            SUM(GAS_MMSCFD) as GAS_MMSCFD,
            SUM(TOTAL_MBOEPD) as TOTAL_MBOEPD,
            SUM(WI_MBOEPD) as WI_MBOEPD");

            if ($typeDate == 'daily') {
                //data for first month to last month
                $rowDashboard->whereRaw("TRUNC(created_at) between to_date('" . date('Y-m-01') . "') and to_date('" . date('Y-m-t') . "')");
                $budgetDashboard->whereRaw("TRUNC(created_at) between to_date('" . date('Y-m-01') . "') and to_date('" . date('Y-m-t') . "')");
            }
            if ($typeDate == 'yearToDate') {
                //data for first month to last month
                $rowDashboard->whereRaw("TRUNC(created_at) between to_date('" . date('Y-01-01') . "') and to_date('" . date('Y-m-t') . "')");
                //data budget dashboard
                $budgetDashboard->whereRaw("TRUNC(created_at) between to_date('" . date('Y-01-01') . "') and to_date('" . date('Y-m-t') . "')");
            }
            $rowDashboard = $rowDashboard->first();
            $rowBudget = $budgetDashboard->first();
            $map = array(
                'id' => $row->id,
                'name' => $row->keterangan,
                'gros_oil' => (float) $rowDashboard->gross_oil_bopd,
                'gros_sale' => (float) $rowDashboard->gross_gas_mmscfd,
                'gros_gas_boepd' => (float) $rowDashboard->gross_gas_boepd,
                'gros_total' => (float) $rowDashboard->gross_total_mboepd,
                'wi_oil' => (float) $rowDashboard->wi_oil_bopd,
                'wi_sale' => (float) $rowDashboard->wi_gas_mmscfd,
                'wi_gas_boepd' => (float)$rowDashboard->wi_gas_boepd,
                'wi_total' => (float) $rowDashboard->wi_total_mboepd,
                'wi_mboepd' => (float) $rowDashboard->wi_mboepd,
                //budget
                'budget_oil' => (float) $rowBudget->oil_bopd,
                'budget_gas' => (float) $rowBudget->gas_mmscfd,
                'budget_total' => (float) $rowBudget->total_mboepd,
                'budget_wi' => (float) $rowBudget->wi_mboepd,
            );
            //get key for array map
            $dataAll[] = $map;
            if (in_array($row->id, $params['emp-operated'])) {
                $prod[] = $map;
            }
            if (in_array($row->id, $params['emp-join'])) {
                $prodJoin[] = $map;
            }
            if (in_array($row->id, $params['emp-non-operated'])) {
                $empNon[] = $map;
            }
        }
        $dataProd = array(
            'tanggal_ending' => \Carbon\Carbon::now()->format('d M Y h:i:s'),
            'dataProduction' => $prod,
            'dataProductionJoin' => $prodJoin,
            'dataProductionEmpNonOperated' => $empNon,
            'dataTotal' => $this->mappingTotal($dataAll)
        );
        return $dataProd;
    }

    private function mappingTotal($dataAll)
    {
        $dataTotal = array();
        $dataTotal['name'] = "Total";
        $dataTotal['gros_oil'] = array_sum(array_column($dataAll, 'gros_oil'));
        $dataTotal['gros_sale'] = array_sum(array_column($dataAll, 'gros_sale'));
        $dataTotal['gros_gas_boepd'] = array_sum(array_column($dataAll, 'gros_gas_boepd'));
        $dataTotal['gros_total'] = array_sum(array_column($dataAll, 'gros_total'));
        $dataTotal['wi_oil'] = array_sum(array_column($dataAll, 'wi_oil'));
        $dataTotal['wi_sale'] = array_sum(array_column($dataAll, 'wi_sale'));
        $dataTotal['wi_gas_boepd'] = array_sum(array_column($dataAll, 'wi_gas_boepd'));
        $dataTotal['wi_total'] = array_sum(array_column($dataAll, 'wi_total'));
        $dataTotal['wi_mboepd'] = array_sum(array_column($dataAll, 'wi_mboepd'));
        $dataTotal['budget_oil'] = array_sum(array_column($dataAll, 'budget_oil'));
        $dataTotal['budget_gas'] = array_sum(array_column($dataAll, 'budget_gas'));
        $dataTotal['budget_total'] = array_sum(array_column($dataAll, 'budget_total'));
        $dataTotal['budget_wi'] = array_sum(array_column($dataAll, 'budget_wi'));
        return $dataTotal;
    }

    public function daily(Request $request)
    {
        $data['menu'] = Menu::menu();
        $dataProd = $this->getDataDashboard('daily');
        $data['dummy'] = $dataProd;
        $data['year'] = $this->getDataDashboard('yearToDate');
        return view($this->dirView . '.management-bod', $data);
    }

    //Dashboard Weekly

    public function weekly(Request $request)
    {
        $data['menu'] = Menu::menu();
        //date first week
        $dateFirstWeek = \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');
        //date last week
        $dateLastWeek = \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d');
        $range = $dateFirstWeek . ' to ' . $dateLastWeek;

        $dateFirstWeekBefore = \Carbon\Carbon::parse($dateFirstWeek)->subDays(7)->format('Y-m-d');
        $dateLastWeekBefore = \Carbon\Carbon::parse($dateFirstWeekBefore)->endOfWeek()->format('Y-m-d');
        //query for last week data
        $dataProdLastWeek = $this->getDataDashboardWeekly($dateFirstWeekBefore, $dateLastWeekBefore);

        if (isset($request->range)) {
            $range = $request->range;
            $dateFirstWeek = explode(' to ', $range)[0];
            $dateLastWeek = explode(' to ', $range)[1];

            $dateFirstWeekBefore = \Carbon\Carbon::parse($dateFirstWeek)->subDays(7)->format('Y-m-d');
            $dateLastWeekBefore = \Carbon\Carbon::parse($dateFirstWeekBefore)->endOfWeek()->format('Y-m-d');
            //query for last week data
            $dataProdLastWeek = $this->getDataDashboardWeekly($dateFirstWeekBefore, $dateLastWeekBefore);
        }
        //data dashboard week
        $dataProd = $this->getDataDashboardWeekly($dateFirstWeek, $dateLastWeek);
        $tanggal = $dataProd->pluck('tanggal')->unique()->values()->toArray();
        if (empty($tanggal)) {
            return redirect()->back()->with('error', 'Belum ada data untuk range ' . $range);
        }
        $data['labelTanggal'] = $tanggal;
        $summary = collect($dataProd)->groupBy('name')->map(function ($item, $key) {
            //get value column gross_total_mboepd
            $gasTotal = array_column($item->toArray(), 'gross_gas_mmscfd');
            $oilTotal = array_column($item->toArray(), 'gross_oil_bopd');

            $wiOilTotal = array_column($item->toArray(), 'wi_oil_bopd');
            $wiGasTotal = array_column($item->toArray(), 'wi_gas_mmscfd');

            $temp = [];
            $temp['name'] = $item->first()['name'];
            $temp['gas'] = array_map('intval', $gasTotal);
            $temp['oil'] = array_map('intval', $oilTotal);
            //set total Gas & Oil
            $temp['totalGas'] = array_sum($gasTotal);
            $temp['totalOil'] = array_sum($oilTotal);
            //set total WI Gas & Oil
            $temp['wiOil'] = array_map('intval', $wiOilTotal);
            $temp['wiGas'] = array_map('intval', $wiGasTotal);

            return $temp;
        })->values();
        $averageGas = $summary->pluck('totalGas')->avg();
        $averageOil = $summary->pluck('totalOil')->avg();
        $data['averageGas'] = number_format($averageGas, '3', ',', '.');
        $data['averageOil'] = number_format($averageOil, '3', ',', '.');
        //mapping data parse graph
        $dataOil = array();
        $dataGas = array();
        $dataOilSummary = array();
        $dataGasSummary = array();

        foreach ($summary as $idx => $row) {
            $lastOilGas = $dataProdLastWeek->where('name', $row['name'])->toArray();

            $lastSumOil = array_sum(array_column($lastOilGas, 'gross_oil_bopd'));
            $lastSumGas = array_sum(array_column($lastOilGas, 'gross_gas_mmscfd'));


            //data for gas
            $dataGas[$idx]['name'] = $row['name'];
            $dataGas[$idx]['data'] = $row['gas'];
            $dataGas[$idx]['type'] = "column";
            //data for oil
            $dataOil[$idx]['name'] = $row['name'];
            $dataOil[$idx]['data'] = $row['oil'];
            $dataOil[$idx]['type'] = "column";

            $dataOilSummary[$idx]['name'] = $row['name'];
            $dataOilSummary[$idx]['this_week'] = $row['totalOil']; //sum row oil
            $dataOilSummary[$idx]['last_week'] = $lastSumOil; //sum row oil
            $dataOilSummary[$idx]['wi'] = array_sum($row['wiOil']); //sum row oil

            $dataGasSummary[$idx]['name'] = $row['name'];
            $dataGasSummary[$idx]['this_week'] = $row['totalGas']; //sum row gas
            $dataGasSummary[$idx]['last_week'] = $lastSumGas; //sum row gas
            $dataGasSummary[$idx]['wi'] = array_sum($row['wiGas']); //sum gas

        }

        $data['dataGas'] = $dataGas;
        $data['dataOil'] = $dataOil;
        $data['filterRange'] = $range;
        $data['filterFirstWeek'] = $dateFirstWeek;
        $data['filterLastWeek'] = $dateLastWeek;
        //sample format data
        // [
        //     "name" => "Malacca",
        //     "last_week" => "5.037",
        //     "this_week" => (rand() + 0.2),
        //     "prod" => (rand() + 0.5),
        //     "sales" => (rand() / 0.2),
        //     "oct_target" => (rand() + 1.3),
        //     "wi" => (rand() + 2.2),
        //     "percent" => (rand() * 0.2) . '%'
        // ]
        $data['dataOilSummary'] = $dataOilSummary;
        $data['dataGasSummary'] = $dataGasSummary;


        return view($this->dirView . '.management-weekly', $data);
    }
    private function getDataDashboardWeekly($firstDate, $lastDate)
    {
        if (!empty($firstDate) && !empty($lastDate)) {
            $data = Dashboard::whereRaw("created_at between to_date('" . $firstDate . "', 'YYYY-MM-DD') AND to_date('" . $lastDate . "', 'YYYY-MM-DD')");
        }
        $data->selectRaw("
        to_char(created_at, 'YYYY-MM-DD') as tanggal,
        (SELECT keterangan FROM business_units where id = dashboard.code) as name,
        gross_oil_bopd,
        gross_gas_mmscfd,
        gross_gas_boepd,
        gross_total_mboepd,
        wi_oil_bopd,
        wi_gas_mmscfd,
        wi_gas_boepd,
        wi_total_mboepd,
        wi_mboepd");
        // $data->groupByRaw("to_char(created_at,'YYYY-MM-DD'), code");
        $data->orderByRaw('to_char(created_at,\'YYYY-MM-DD\') asc');
        $result = $data->get();
        return $result;
    }

    //Dashboard Yearly

    public function yearly(Request $request)
    {
        $tahun = date('Y');
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        }
        $data['filterTahun'] = $tahun;
        $data['menu'] = Menu::menu();
        $yearly = $this->getDataDashboardYearly($tahun);
        $bulan = $yearly->pluck('bulan')->unique()->values()->toArray();
        if (empty($bulan)) {
            return redirect()->back()->with('error', 'Belum ada data untuk tahun ' . $tahun);
        }
        $labelBulan = array();
        foreach ($bulan as $bulans) {
            $labelBulan[] = bulanIndo($bulans);
        }
        $data['labelBulan'] = $labelBulan;
        $summary = collect($yearly)->groupBy('name')->map(function ($item, $key) {
            //get value column gross_total_mboepd
            $gasTotal = array_column($item->toArray(), 'gross_total_mboepd');
            $oilTotal = array_column($item->toArray(), 'wi_total_mboepd');
            $temp = [];
            $temp['name'] = $item->first()['name'];
            $temp['gas_total'] = array_map('intval', $gasTotal);
            $temp['oil_total'] = array_map('intval', $oilTotal);
            return $temp;
        })->values();

        $map = $summary->toArray();
        $jsonMap = array();
        $gas = array();
        $oil = array();
        foreach ($map as $key => $val) {
            //data for gas
            $gas['name'] = $val['name'] . ' Gas';
            $gas['data'] = $val['gas_total'];
            $gas['type'] = "column";
            //data for oil
            $oil['name'] = $val['name'] . ' Oil';
            $oil['data'] = $val['oil_total'];
            $oil['type'] = "column";
            //push data to array
            $jsonMap[] = $gas;
            $jsonMap[] = $oil;
        }
        $data['result'] = $jsonMap;
        return view($this->dirView . '.management-yearly', $data);
    }

    private function getDataDashboardYearly($tahun = null)
    {
        if (empty($tahun)) {
            $data = Dashboard::whereRaw("to_char(created_at, 'YYYY') = '" . date('Y') . "'");
        } else {
            $data = Dashboard::whereRaw("to_char(created_at, 'YYYY') = '" . $tahun . "'");
        }
        $data->selectRaw("
        to_char(CREATED_AT,'MM') as bulan,
        (SELECT keterangan FROM business_units where id = dashboard.code) as name,
        SUM(GROSS_OIL_BOPD) as GROSS_OIL_BOPD,
        SUM(GROSS_GAS_MMSCFD) as GROSS_GAS_MMSCFD,
        SUM(GROSS_GAS_BOEPD) as GROSS_GAS_BOEPD,
        SUM(GROSS_TOTAL_MBOEPD) as GROSS_TOTAL_MBOEPD,
        SUM(WI_OIL_BOPD) as WI_OIL_BOPD,
        SUM(WI_GAS_MMSCFD) as WI_GAS_MMSCFD,
        SUM(WI_GAS_BOEPD) as WI_GAS_BOEPD,
        SUM(WI_TOTAL_MBOEPD) as WI_TOTAL_MBOEPD,
        SUM(WI_MBOEPD) as WI_MBOEPD");
        $data->groupByRaw("to_char(created_at,'MM'), code");
        $data->orderByRaw('to_char(created_at,\'MM\') asc');
        $result = $data->get();
        return $result;
    }

    private function dummyData()
    {
        $data = array(
            'tanggal_ending' => '22 Desember 2021',
            'dataProduction' =>
            array(
                0 =>
                array(
                    'id' => 1,
                    'name' => 'MS',
                    'gros_oil' => 5.446,
                    'gros_sale' => 0.49,
                    'gros_total' => 5.52,
                    'wi_oil' => 5.446,
                    'wi_sale' => 0.49,
                    'wi_total' => 5.52,
                    'budget_oil' => 6.037,
                    'budget_gas' => 3.5,
                    'budget_total' => 6.62,
                    'wi_mboepd' => 6.62,
                ),
                1 =>
                array(
                    'id' => 2,
                    'name' => 'Bentu',
                    'gros_oil' => 0,
                    'gros_sale' => 81.03,
                    'gros_total' => 13.51,
                    'wi_oil' => 0,
                    'wi_sale' => 81.03,
                    'wi_total' => 13.51,
                    'budget_oil' => 0,
                    'budget_gas' => 87.0,
                    'budget_total' => 14.5,
                    'wi_mboepd' => 14.5,
                ),
                2 =>
                array(
                    'id' => 3,
                    'name' => 'Tonga',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                    'budget_oil' => 0,
                    'budget_gas' => 0,
                    'budget_total' => 0,
                    'wi_mboepd' => 0,
                ),
                3 =>
                array(
                    'id' => 4,
                    'name' => 'Gebang',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                    'budget_oil' => 0,
                    'budget_gas' => 3.0,
                    'budget_total' => 0.5,
                    'wi_mboepd' => 0.25,
                ),
                4 =>
                array(
                    'id' => 5,
                    'name' => 'Korinci',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                    'budget_oil' => 0,
                    'budget_gas' => 0,
                    'budget_total' => 0,
                    'wi_mboepd' => 0,
                ),
                5 =>
                array(
                    'id' => 6,
                    'name' => 'BUZI',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                    'budget_oil' => 0,
                    'budget_gas' => 0,
                    'budget_total' => 0,
                    'wi_mboepd' => 0,
                ),
            ),
            'dataProductionJoin' =>
            array(
                0 =>
                array(
                    'id' => 0,
                    'name' => 'Kangean',
                    'gros_oil' => 57,
                    'gros_sale' => 145.73,
                    'gros_total' => 24.66,
                    'wi_oil' => 43,
                    'wi_sale' => 109.3,
                    'wi_total' => 18.5,
                    'budget_oil' => 73,
                    'budget_gas' => 109.87,
                    'budget_total' => 18.38,
                    'wi_mboepd' => 13.79,
                ),
            ),
            'dataProductionEmpNonOperated' =>
            array(
                0 =>
                array(
                    'name' => 'Sengkang **',
                    'gros_oil' => 0,
                    'gros_sale' => 32.66,
                    'gros_total' => 5.61,
                    'wi_oil' => 0,
                    'wi_sale' => 16.0,
                    'wi_total' => 2.75,
                    'budget_oil' => 0,
                    'budget_gas' => 34.59,
                    'budget_total' => 5.77,
                    'wi_mboepd' => 2.82,
                ),
                1 =>
                array(
                    'name' => 'WKB',
                    'gros_oil' => 791,
                    'gros_sale' => 12.59,
                    'gros_total' => 2.89,
                    'wi_oil' => 388,
                    'wi_sale' => 6.17,
                    'wi_total' => 1.42,
                    'budget_oil' => 629,
                    'budget_gas' => 11.43,
                    'budget_total' => 2.53,
                    'wi_mboepd' => 1.24,
                ),
            ),
            'dataTotal' =>
            array(
                0 =>
                array(
                    'name' => 'Total',
                    'gros_oil' => 6.294,
                    'gros_sale' => 272.5,
                    'gros_total' => 52.18,
                    'wi_oil' => 5.876,
                    'wi_sale' => 212.99,
                    'wi_total' => 41.68,
                    'budget_oil' => 6.74,
                    'budget_gas' => 249.39,
                    'budget_total' => 48.3,
                    'wi_mboepd' => 39.23,
                ),
            ),
        );
        return $data;
    }

    private function dummyYearBod()
    {
        $data = array(
            'dataProduction' =>
            array(
                0 =>
                array(
                    'id' => 1,
                    'name' => 'MS',
                    'gros_oil' => 4.776,
                    'gros_sale' => 0.43,
                    'gros_total' => 4.85,
                    'wi_oil' => 6.85,
                    'wi_sale' => 4.85,
                    'wi_total' => 6.85,
                ),
                1 =>
                array(
                    'id' => 2,
                    'name' => 'Bentu',
                    'gros_oil' => 0,
                    'gros_sale' => 79.85,
                    'gros_total' => 13.31,
                    'wi_oil' => 14.5,
                    'wi_sale' => 13.31,
                    'wi_total' => 14.5,
                ),
                2 =>
                array(
                    'id' => 3,
                    'name' => 'Tonga',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                ),
                3 =>
                array(
                    'id' => 4,
                    'name' => 'Korinci',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                ),
                4 =>
                array(
                    'id' => 5,
                    'name' => 'Gebang',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0.42,
                    'wi_sale' => 0,
                    'wi_total' => 0.21,
                ),
                5 =>
                array(
                    'id' => 6,
                    'name' => 'BUZI',
                    'gros_oil' => 0,
                    'gros_sale' => 0,
                    'gros_total' => 0,
                    'wi_oil' => 0,
                    'wi_sale' => 0,
                    'wi_total' => 0,
                ),
            ),
            'dataProductionJoin' =>
            array(
                0 =>
                array(
                    'id' => 0,
                    'name' => 'Kangean',
                    'gros_oil' => 65,
                    'gros_sale' => 159.42,
                    'gros_total' => 26.63,
                    'wi_oil' => 25.62,
                    'wi_sale' => 19.98,
                    'wi_total' => 14.76,
                ),
            ),
            'dataProductionEmpNonOperated' =>
            array(
                0 =>
                array(
                    'name' => 'Sengkang',
                    'gros_oil' => 0,
                    'gros_sale' => 39.55,
                    'gros_total' => 6.59,
                    'wi_oil' => 6.0,
                    'wi_sale' => 3.23,
                    'wi_total' => 2.94,
                ),
                1 =>
                array(
                    'name' => 'WKB',
                    'gros_oil' => 914,
                    'gros_sale' => 10.36,
                    'gros_total' => 2.64,
                    'wi_oil' => 2.93,
                    'wi_sale' => 1.29,
                    'wi_total' => 1.43,
                ),
            ),
            'dataTotal' =>
            array(
                0 =>
                array(
                    'name' => 'Total',
                    'gros_oil' => 5.755,
                    'gros_sale' => 289.6,
                    'gros_total' => 54.02,
                    'wi_oil' => 56.32,
                    'wi_sale' => 42.66,
                    'wi_total' => 40.69,
                ),
            ),
        );
        return $data;
    }

    private function dummyWeekly()
    {
        $data = [
            [
                "name" => "Malacca", "last_week" => "5.037", "this_week" => (rand() + 0.2), "prod" => (rand() + 0.5), "sales" => (rand() / 0.2), "oct_target" => (rand() + 1.3), "wi" => (rand() + 2.2), "percent" => (rand() * 0.2) . '%'
            ],
            [
                "name" => "Sengkang", "last_week" => "5.037", "this_week" => (rand() + 0.2), "prod" => (rand() + 0.5), "sales" => (rand() / 0.2), "oct_target" => (rand() + 1.3), "wi" => (rand() + 2.2), "percent" => (rand() * 0.2) . '%'
            ],
            [
                "name" => "Gebang", "last_week" => "5.037", "this_week" => (rand() + 0.2), "prod" => (rand() + 0.5), "sales" => (rand() / 0.2), "oct_target" => (rand() + 1.3), "wi" => (rand() + 2.2), "percent" => (rand() * 0.2) . '%'
            ],
            [
                "name" => "Tonga", "last_week" => "5.037", "this_week" => (rand() + 0.2), "prod" => (rand() + 0.5), "sales" => (rand() / 0.2), "oct_target" => (rand() + 1.3), "wi" => (rand() + 2.2), "percent" => (rand() * 0.2) . '%'
            ],
            [
                "name" => "Kangean", "last_week" => "5.037", "this_week" => (rand() + 0.2), "prod" => (rand() + 0.5), "sales" => (rand() / 0.2), "oct_target" => (rand() + 1.3), "wi" => (rand() + 2.2), "percent" => (rand() * 0.2) . '%'
            ],
            [
                "name" => "WK B", "last_week" => "5.037", "this_week" => (rand() + 0.2), "prod" => (rand() + 0.5), "sales" => (rand() / 0.2), "oct_target" => (rand() + 1.3), "wi" => (rand() + 2.2), "percent" => (rand() * 0.2) . '%'
            ]
        ];
        return $data;
    }

    public function getAll(Request $request)
    {
        $data = $this->newsServices->getAll($request);
        return $data;
    }
    public function hapus($id)
    {
        $data = $this->newsServices->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->newsServices->getById($id);
        return $data;
    }
}
