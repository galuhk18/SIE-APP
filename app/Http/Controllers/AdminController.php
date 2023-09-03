<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PopulationExport;
use App\Exports\FormPopulationExport;
use App\Imports\PopulationImport;
use App\Exports\BirthExport;
use App\Exports\FormBirthExport;
use App\Imports\BirthImport;
use App\Exports\DeathExport;
use App\Exports\FormDeathExport;
use App\Imports\DeathImport;
use App\Exports\ServiceExport;
use App\Exports\DecisionExport;
use App\Exports\ActivityExport;
use App\Exports\FormActivityExport;
use App\Imports\ActivityImport;
use App\Exports\FundingPetitionExport;
use App\Exports\ActivityReportExport;
use App\Exports\BuildingManagementExport;
use App\Exports\FacilityManagementExport;
use App\Exports\BuildingRentalExport;
use App\Exports\FacilityRentalExport;
use App\Exports\FacilityCompensationExport;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function index()
    {
        $data['population_amount'] = DB::table('population')->count();
        $data['service_amount'] = DB::table('service')->count();
        $data['decision_amount'] = DB::table('decision')->count();
        $data['birth_death_amount'] = DB::table('birth')->count() + DB::table('death')->count();

        $year_now = Carbon::now()->year;
        $month_name = ["Januari", "Feburari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        // Funding Petition
        $funding_petition = DB::table('funding_petition')
            ->selectRaw('month(created_at) as month, sum(budget_amount) as budget_amount,count(*) as amount')
            ->groupByRaw('month(created_at)')
            ->where('status', 1)
            ->whereYear('created_at', $year_now)
            ->get();

        $fp = [];
        $fb = [];
        foreach ($funding_petition as $fu) {
            $fp['label'][] = $month_name[$fu->month];
            $fp['data'][] = (int) $fu->amount;

            $fb['label'][] = $month_name[$fu->month];
            $fb['data'][] = (int) $fu->budget_amount;
        }

        $data['chart_funding_petition_amount'] = json_encode($fp);
        $data['chart_funding_petition_budget_amount'] = json_encode($fb);

        // Birth and Death

        $birth = DB::table('birth')->count();
        $death = DB::table('death')->count();

        $bd = [
            "label" => ["kelahiran", "kematian"],
            "data" => [$birth, $death]
        ];

        $data['chart_birth_death'] = json_encode($bd);

        // Top building rentals
        $building = DB::table('building_rental')
            ->selectRaw('building_code, count(*) amount')
            ->where('status', 3)
            ->groupBy('building_code')
            ->orderByDesc('amount')
            ->get();
        $bud = [];
        foreach ($building as $bu) {
            $bud['label'][] = $bu->building_code;
            $bud['data'][] = $bu->amount;
        }
        $data['chart_building_rental'] = json_encode($bud);
        // Top Facility rentals
        $facility = DB::table('facility_rental')
            ->selectRaw('facility_code, count(*) amount')
            ->where('status', 3)
            ->groupBy('facility_code')
            ->orderByDesc('amount')
            ->get();
        $fac = [];
        foreach ($facility as $fa) {
            $fac['label'][] = $fa->facility_code;
            $fac['data'][] = $fa->amount;
        }
        $data['chart_facility_rental'] = json_encode($fac);

        $data['year'] = $year_now;
        return view('admin.index', $data);
    }

    // Population
    public function population_index()
    {
        $data['population_amount'] = DB::table('population')->count();
        $data['population'] = DB::table('population')->get();

        if(session()->has('executive_id')) {
            $male = DB::table('population')
                        ->where('gender','pria')
                        ->count();
            $female = DB::table('population')
                        ->where('gender','wanita')
                        ->count();

            $menikah = DB::table('population')
                        ->where('married','menikah')
                        ->count();
            
            $belum_menikah = DB::table('population')
                        ->where('married','belum menikah')
                        ->count();


            $gender['label'] = ["pria","wanita"];
            $gender['data'] = [$male, $female];

            $married['label'] = ["menikah","belum menikah"];
            $married['data'] = [$menikah, $belum_menikah];

            $data['chart_gender'] = json_encode($gender);
            $data['chart_married'] = json_encode($married);
        }

        return view('admin.population.index', $data);
    }
    public function population_create()
    {
        $data['religion'] = Config::get('enums.religion');
        $data['married'] = Config::get('enums.married');
        $data['gender'] = Config::get('enums.gender');
        $data['citizenship'] = Config::get('enums.citizenship');

        return view('admin.population.create', $data);
    }

    public function population_store(Request $req)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'family_card' => 'required|min:16|max:16',
            'name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'birth_place' => 'required',
            'phone_number' => 'required',
            'religion' => 'required',
            'citizenship' => 'required',
            'married' => 'required',
            'job' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        try {
            //code...
            DB::table('population')->insert([
                'nik' => $req->nik,
                'family_card' => $req->family_card,
                'name' => $req->name,
                'gender' => $req->gender,
                'address' => $req->address,
                'date_of_birth' => $req->date_of_birth,
                'birth_place' => $req->birth_place,
                'phone_number' => $req->phone_number,
                'religion' => $req->religion,
                'citizenship' => $req->citizenship,
                'married' => $req->married,
                'job' => $req->job,
                'father_name' => $req->father_name,
                'mother_name' => $req->mother_name,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('population.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function population_edit($id)
    {
        $data['religion'] = Config::get('enums.religion');
        $data['married'] = Config::get('enums.married');
        $data['gender'] = Config::get('enums.gender');
        $data['citizenship'] = Config::get('enums.citizenship');
        $data['population'] = DB::table('population')->where('id', $id)->first();
        return view('admin.population.edit', $data);
    }

    public function population_update(Request $req, $id)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'family_card' => 'required|min:16|max:16',
            'name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'birth_place' => 'required',
            'phone_number' => 'required',
            'religion' => 'required',
            'citizenship' => 'required',
            'married' => 'required',
            'job' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        try {
            //code...
            DB::table('population')
                ->where('id', $id)
                ->update([
                    'nik' => $req->nik,
                    'family_card' => $req->family_card,
                    'name' => $req->name,
                    'gender' => $req->gender,
                    'address' => $req->address,
                    'date_of_birth' => $req->date_of_birth,
                    'birth_place' => $req->birth_place,
                    'phone_number' => $req->phone_number,
                    'religion' => $req->religion,
                    'citizenship' => $req->citizenship,
                    'married' => $req->married,
                    'job' => $req->job,
                    'father_name' => $req->father_name,
                    'mother_name' => $req->mother_name,
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('population.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function population_destroy($id)
    {
        try {
            $check = DB::table('population')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('Population not found');
                return back();
            }

            DB::table('population')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('population.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function population_export()
    {
        $name = 'population-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new PopulationExport, $name);
    }

    public function population_form_export()
    {
        $name = 'form-population-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FormPopulationExport, $name);
    }

    public function population_import(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validate->fails()) {

            return back()
                ->with('error_add', 'Error')
                ->withErrors($validate);
        }

        try {

            Excel::import(new PopulationImport, $req->file('file'));
            Alert::success('Success');
            return back();
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }
    // Birth
    public function birth_index()
    {
        $data['birth'] = DB::table('birth')->get();
        $data['birth_amount'] = DB::table('birth')->count();

        if(session()->has('executive_id')) {
            $male = DB::table('birth')
                        ->where('gender','pria')
                        ->count();
            $female = DB::table('birth')
                        ->where('gender','wanita')
                        ->count();
            $gender['label'] = ["pria","wanita"];
            $gender['data'] = [$male, $female];
            $data['chart_gender'] = json_encode($gender);
        }

        return view('admin.birth.index', $data);
    }

    public function birth_create()
    {
        $data['gender'] = Config::get('enums.gender');
        return view('admin.birth.create', $data);
    }

    public function birth_store(Request $req)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'no_akta' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        try {

            DB::table('birth')->insert([
                'nik' => $req->nik,
                'no_akta' => $req->no_akta,
                'name' => $req->name,
                'gender' => $req->gender,
                'address' => $req->address,
                'date_of_birth' => $req->date_of_birth,
                'father_name' => $req->father_name,
                'mother_name' => $req->mother_name,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('birth.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function birth_edit($id)
    {
        $data['birth'] = DB::table('birth')
            ->where('id', $id)
            ->first();
        $data['gender'] = Config::get('enums.gender');
        return view('admin.birth.edit', $data);
    }

    public function birth_update(Request $req, $id)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'no_akta' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        try {
            //code...
            DB::table('birth')
                ->where('id', $id)
                ->update([
                    'nik' => $req->nik,
                    'no_akta' => $req->no_akta,
                    'name' => $req->name,
                    'gender' => $req->gender,
                    'address' => $req->address,
                    'date_of_birth' => $req->date_of_birth,
                    'father_name' => $req->father_name,
                    'mother_name' => $req->mother_name,
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('birth.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function birth_destroy($id)
    {
        try {
            $check = DB::table('birth')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('Birth not found');
                return back();
            }

            DB::table('birth')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('birth.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function birth_export()
    {
        $name = 'birth-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new BirthExport, $name);
    }

    public function birth_form_export()
    {
        $name = 'form-birth-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FormBirthExport, $name);
    }

    public function birth_import(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validate->fails()) {

            return back()
                ->with('error_add', 'Error')
                ->withErrors($validate);
        }

        try {

            Excel::import(new BirthImport, $req->file('file'));
            Alert::success('Success');
            return back();
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }
    // Death
    public function death_index()
    {
        $data['death'] = DB::table('death')->get();
        $data['death_amount'] = DB::table('death')->count();
        if(session()->has('executive_id')) {
            $year_now = Carbon::now()->year;
            $month_name = ["Januari", "Feburari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $death = DB::table('death')
                        ->selectRaw('month(date_of_death) as month ,count(*) as amount')
                        ->groupByRaw('month(date_of_death)')
                        ->whereYear('date_of_death', $year_now)
                        ->get();
            
            $dead = [];
            foreach($death as $de) {
                $dead['label'][] = $month_name[$de->month - 1];
                $dead['data'][] = (int) $de->amount;
            }
            $data['year'] = $year_now;
            $data['chart_death'] = json_encode($dead);
        }
        return view('admin.death.index', $data);
    }

    public function death_create()
    {
        return view('admin.death.create');
    }

    public function death_store(Request $req)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'family_card' => 'required|min:16|max:16',
            'name' => 'required',
            'address' => 'required',
            'date_of_death' => 'required',
            'informer' => 'required',
            'informer_status' => 'required',
        ]);

        try {
            //code...
            DB::table('death')->insert([
                'nik' => $req->nik,
                'family_card' => $req->family_card,
                'name' => $req->name,
                'address' => $req->address,
                'date_of_death' => $req->date_of_death,
                'informer' => $req->informer,
                'informer_status' => $req->informer_status,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('death.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function death_edit($id)
    {
        $data['death'] = DB::table('death')
            ->where('id', $id)
            ->first();
        return view('admin.death.edit', $data);
    }

    public function death_update(Request $req, $id)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'family_card' => 'required|min:16|max:16',
            'name' => 'required',
            'address' => 'required',
            'date_of_death' => 'required',
            'informer' => 'required',
            'informer_status' => 'required',
        ]);

        try {
            //code...
            DB::table('death')
                ->where('id', $id)
                ->update([
                    'nik' => $req->nik,
                    'family_card' => $req->family_card,
                    'name' => $req->name,
                    'address' => $req->address,
                    'date_of_death' => $req->date_of_death,
                    'informer' => $req->informer,
                    'informer_status' => $req->informer_status,
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('death.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function death_destroy($id)
    {
        try {
            $check = DB::table('death')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('Death not found');
                return back();
            }

            DB::table('death')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('death.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function death_export()
    {
        $name = 'death-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new DeathExport, $name);
    }

    public function death_form_export()
    {
        $name = 'form-death-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FormDeathExport, $name);
    }

    public function death_import(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validate->fails()) {

            return back()
                ->with('error_add', 'Error')
                ->withErrors($validate);
        }

        try {

            Excel::import(new DeathImport, $req->file('file'));
            Alert::success('Success');
            return back();
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }
    // Decision
    public function decision_index()
    {
        $data['decision'] = DB::table('decision')->get();
        $data['decision_amount'] = DB::table('decision')->count();
        if(session()->has('executive_id')) {
            $year_now = Carbon::now()->year;
            $month_name = ["Januari", "Feburari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $decision = DB::table('decision')
                        ->selectRaw('month(decision_date) as month ,count(*) as amount')
                        ->groupByRaw('month(decision_date)')
                        ->whereYear('decision_date', $year_now)
                        ->get();
            
            $dec = [];
            foreach($decision as $de) {
                $dec['label'][] = $month_name[$de->month - 1];
                $dec['data'][] = (int) $de->amount;
            }
            $data['year'] = $year_now;
            $data['chart_decision'] = json_encode($dec);
            
        }
        return view('admin.decision.index', $data);
    }

    public function decision_create()
    {
        return view('admin.decision.create');
    }

    public function decision_store(Request $req)
    {
        $req->validate([
            'decision' => 'required',
            'type_of_decision' => 'required',
            'decision_date' => 'required',
            'problem' => 'required',
            'documentasion' => 'max:1000|file|image',
            'realization_date' => 'required',
        ]);
        try {
            if ($req->hasFile('documentasion')) {
                $extFile = $req->documentasion->getClientOriginalExtension();
                $namaFile = 'decision-' . time() . "." . $extFile;
                $path = $req->documentasion->move('img/decision', $namaFile);

                DB::table('decision')->insert([
                    'decision' => $req->decision,
                    'type_of_decision' => $req->type_of_decision,
                    'decision_date' => $req->decision_date,
                    'problem' => $req->problem,
                    'documentasion' => $path,
                    'realization_date' => $req->realization_date,
                    'created_at' => Carbon::now()
                ]);
            } else {
                DB::table('decision')->insert([
                    'decision' => $req->decision,
                    'type_of_decision' => $req->type_of_decision,
                    'decision_date' => $req->decision_date,
                    'problem' => $req->problem,
                    'documentasion' => null,
                    'realization_date' => $req->realization_date,
                    'created_at' => Carbon::now()
                ]);
            }


            Alert::success('Success');

            return redirect(route('decision.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function decision_edit($id)
    {
        $data['decision'] = DB::table('decision')
            ->where('id', $id)
            ->first();
        return view('admin.decision.edit', $data);
    }

    public function decision_update(Request $req, $id)
    {
        $req->validate([
            'decision' => 'required',
            'type_of_decision' => 'required',
            'decision_date' => 'required',
            'problem' => 'required',
            'documentasion' => 'max:1000|file|image',
            'realization_date' => 'required',
        ]);
        try {

            if ($req->hasFile('documentasion')) {
                $extFile = $req->documentasion->getClientOriginalExtension();
                $namaFile = 'decision-' . time() . "." . $extFile;
                $path = $req->documentasion->move('img/decision', $namaFile);

                DB::table('decision')
                    ->where('id', $id)
                    ->update([
                        'decision' => $req->decision,
                        'type_of_decision' => $req->type_of_decision,
                        'decision_date' => $req->decision_date,
                        'problem' => $req->problem,
                        'documentasion' => $path,
                        'realization_date' => $req->realization_date,
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('decision')
                    ->where('id', $id)
                    ->update([
                        'decision' => $req->decision,
                        'type_of_decision' => $req->type_of_decision,
                        'decision_date' => $req->decision_date,
                        'problem' => $req->problem,
                        'realization_date' => $req->realization_date,
                        'updated_at' => Carbon::now()
                    ]);
            }

            Alert::success('Success');

            return redirect(route('decision.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function decision_destroy($id)
    {
        try {
            $check = DB::table('decision')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('decision not found');
                return back();
            }

            DB::table('decision')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('decision.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function decision_export()
    {
        $name = 'decision-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new DecisionExport, $name);
    }
    // Service
    public function service_index()
    {


        $data['service'] = DB::table('service')->get();
        $data['service_amount'] = DB::table('service')->count();
        if(session()->has('executive_id')) {
            $service_type = Config::get('enums.service_type');
            $service = [];
            foreach($service_type as $st) {
                $service['label'][] = $st;
                $service['data'][] = DB::table('service')->where('service_type', $st)->count();
            }
    
            $data['chart_service'] = json_encode($service);
        }

        return view('admin.service.index', $data);
    }

    public function service_create()
    {
        $data['service_type'] =  Config::get('enums.service_type');
        return view('admin.service.create', $data);
    }

    public function service_store(Request $req)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'name' => 'required',
            'date_of_service' => 'required',
            'information' => 'required',
            'service_type' => 'required',
        ]);
        try {

            DB::table('service')->insert([
                'nik' => $req->nik,
                'name' => $req->name,
                'date_of_service' => $req->date_of_service,
                'information' => $req->information,
                'service_type' => $req->service_type,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('service.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function service_edit($id)
    {
        $data['service'] = DB::table('service')
            ->where('id', $id)
            ->first();
        $data['service_type'] =  Config::get('enums.service_type');
        return view('admin.service.edit', $data);
    }

    public function service_update(Request $req, $id)
    {
        $req->validate([
            'nik' => 'required|min:16|max:16',
            'name' => 'required',
            'date_of_service' => 'required',
            'information' => 'required',
            'service_type' => 'required',
        ]);
        try {

            DB::table('service')
                ->where('id', $id)
                ->update([
                    'nik' => $req->nik,
                    'name' => $req->name,
                    'date_of_service' => $req->date_of_service,
                    'information' => $req->information,
                    'service_type' => $req->service_type,
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('service.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function service_destroy($id)
    {
        try {
            $check = DB::table('service')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('Service not found');
                return back();
            }

            DB::table('service')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('service.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function service_export()
    {
        $name = 'service-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new ServiceExport, $name);
    }
    // Activity
    public function activity_index()
    {
        $data['activity'] = DB::table('activity')->get();
        $data['activity_amount'] = DB::table('activity')->count();
        return view('admin.activity.index', $data);
    }

    public function activity_create()
    {
        return view('admin.activity.create');
    }

    public function activity_store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'date_of_activity' => 'required',
            'address' => 'required',
            'information' => 'required',
        ]);
        try {

            DB::table('activity')->insert([
                'name' => $req->name,
                'date_of_activity' => $req->date_of_activity,
                'address' => $req->address,
                'information' => $req->information,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('activity.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function activity_edit($id)
    {
        $data['activity'] = DB::table('activity')
            ->where('id', $id)
            ->first();
        return view('admin.activity.edit', $data);
    }

    public function activity_update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'date_of_activity' => 'required',
            'address' => 'required',
            'information' => 'required',
        ]);
        try {

            DB::table('activity')
                ->where('id', $id)
                ->update([
                    'name' => $req->name,
                    'date_of_activity' => $req->date_of_activity,
                    'address' => $req->address,
                    'information' => $req->information,
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('activity.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function activity_destroy($id)
    {
        try {
            $check = DB::table('activity')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('Activity not found');
                return back();
            }

            DB::table('activity')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('activity.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function activity_export()
    {
        $name = 'activity-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new ActivityExport, $name);
    }

    public function activity_form_export()
    {
        $name = 'form-activity-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FormActivityExport, $name);
    }

    public function activity_import(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validate->fails()) {

            return back()
                ->with('error_add', 'Error')
                ->withErrors($validate);
        }

        try {

            Excel::import(new ActivityImport, $req->file('file'));
            Alert::success('Success');
            return back();
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }
    // Funding Petition
    public function funding_petition_index()
    {
        $data['funding_petition'] = DB::table('funding_petition')->get();
        $data['funding_petition_amount'] = DB::table('funding_petition')->count();
        $data['funding_petition_amount_status'] = [
            DB::table('funding_petition')->where('status', 0)->count(),
            DB::table('funding_petition')->where('status', 1)->count(),
            DB::table('funding_petition')->where('status', 2)->count(),
        ];
        $data['funding_petition_status'] = Config::get('enums.funding_petition_status');
        return view('admin.funding_petition.index', $data);
    }

    public function funding_petition_create()
    {
        $data['funding_petition_status'] = Config::get('enums.funding_petition_status');
        return view('admin.funding_petition.create', $data);
    }

    public function funding_petition_store(Request $req)
    {
        $req->validate([
            'date_of_activity' => 'required',
            'organization_name' => 'required',
            'budget_amount' => 'required',
            'event_name' => 'required',
            'person_responsible' => 'required',
            'proposal' => 'required|file|mimes:pdf|max:2048',
        ]);

        try {

            $extFile = $req->proposal->getClientOriginalExtension();
            $namaFile = 'proposal-' . time() . "." . $extFile;
            $path = $req->proposal->move('pdf/funding_petition', $namaFile);

            DB::table('funding_petition')->insert([
                'date_of_activity' => $req->date_of_activity,
                'organization_name' => $req->organization_name,
                'budget_amount' => $req->budget_amount,
                'event_name' => $req->event_name,
                'person_responsible' => $req->person_responsible,
                'proposal' => $path,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('funding.petition.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function funding_petition_edit($id)
    {
        $data['funding_petition'] = DB::table('funding_petition')
            ->where('id', $id)
            ->first();
        $data['funding_petition_status'] = Config::get('enums.funding_petition_status');
        return view('admin.funding_petition.edit', $data);
    }

    public function funding_petition_update(Request $req, $id)
    {
        $req->validate([
            'date_of_activity' => 'required',
            'organization_name' => 'required',
            'budget_amount' => 'required',
            'event_name' => 'required',
            'person_responsible' => 'required',
            'proposal' => 'file|mimes:pdf|max:2048',

        ]);
        try {

            if ($req->hasFile('proposal')) {
                $extFile = $req->proposal->getClientOriginalExtension();
                $namaFile = 'proposal-' . time() . "." . $extFile;
                $path = $req->proposal->move('pdf/funding_petition', $namaFile);
                if ($req->status) {

                    DB::table('funding_petition')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'budget_amount' => $req->budget_amount,
                            'event_name' => $req->event_name,
                            'person_responsible' => $req->person_responsible,
                            'proposal' => $path,
                            'status' => $req->status,
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('funding_petition')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'budget_amount' => $req->budget_amount,
                            'event_name' => $req->event_name,
                            'person_responsible' => $req->person_responsible,
                            'proposal' => $path,
                            'updated_at' => Carbon::now()
                        ]);
                }
            } else {
                if ($req->status) {

                    DB::table('funding_petition')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'budget_amount' => $req->budget_amount,
                            'event_name' => $req->event_name,
                            'person_responsible' => $req->person_responsible,
                            'status' => $req->status,
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('funding_petition')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'budget_amount' => $req->budget_amount,
                            'event_name' => $req->event_name,
                            'person_responsible' => $req->person_responsible,
                            'updated_at' => Carbon::now()
                        ]);
                }
            }

            Alert::success('Success');

            return redirect(route('funding.petition.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function funding_petition_destroy($id)
    {
        try {
            $check = DB::table('funding petition')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('funding petition not found');
                return back();
            }

            DB::table('funding_petition')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('funding.petition.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function funding_petition_export()
    {
        $name = 'funding_petition-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FundingPetitionExport, $name);
    }
    // Activity Report
    public function activity_report_index()
    {
        $data['activity_report'] = DB::table('activity_report')->get();
        $data['activity_report_amount'] = DB::table('activity_report')->count();
        $data['activity_report_amount_status'] = [
            DB::table('activity_report')->where('status', 0)->count(),
            DB::table('activity_report')->where('status', 1)->count(),
            DB::table('activity_report')->where('status', 2)->count(),
        ];
        $data['activity_report_status'] = Config::get('enums.activity_report_status');
        return view('admin.activity_report.index', $data);
    }

    public function activity_report_create()
    {
        $data['activity_report_status'] = Config::get('enums.activity_report_status');
        return view('admin.activity_report.create', $data);
    }

    public function activity_report_store(Request $req)
    {
        $req->validate([
            'date_of_activity' => 'required',
            'organization_name' => 'required',
            'information' => 'required',
            'person_responsible' => 'required',
            'documentation' => 'required|max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            $extFile = $req->documentation->getClientOriginalExtension();
            $namaFile = 'documentation-' . time() . "." . $extFile;
            $path = $req->documentation->move('activity_report/documentation', $namaFile);

            DB::table('activity_report')->insert([
                'date_of_activity' => $req->date_of_activity,
                'organization_name' => $req->organization_name,
                'information' => $req->information,
                'person_responsible' => $req->person_responsible,
                'documentation' => $path,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('activity.report.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function activity_report_edit($id)
    {
        $data['activity_report'] = DB::table('activity_report')
            ->where('id', $id)
            ->first();
        $data['activity_report_status'] = Config::get('enums.activity_report_status');
        return view('admin.activity_report.edit', $data);
    }

    public function activity_report_update(Request $req, $id)
    {
        $req->validate([
            'date_of_activity' => 'required',
            'organization_name' => 'required',
            'information' => 'required',
            'person_responsible' => 'required',
            'documentation' => 'max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            if ($req->hasFile('documentation')) {
                $extFile = $req->documentation->getClientOriginalExtension();
                $namaFile = 'documentation-' . time() . "." . $extFile;
                $path = $req->documentation->move('activity_report/documentation', $namaFile);

                if ($req->status) {

                    DB::table('activity_report')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'information' => $req->information,
                            'person_responsible' => $req->person_responsible,
                            'documentation' => $path,
                            'status' => $req->status,
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('activity_report')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'information' => $req->information,
                            'person_responsible' => $req->person_responsible,
                            'documentation' => $path,
                            'updated_at' => Carbon::now()
                        ]);
                }
            } else {
                if ($req->status) {

                    DB::table('activity_report')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'information' => $req->information,
                            'person_responsible' => $req->person_responsible,
                            'status' => $req->status,
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('activity_report')
                        ->where('id', $id)
                        ->update([
                            'date_of_activity' => $req->date_of_activity,
                            'organization_name' => $req->organization_name,
                            'information' => $req->information,
                            'person_responsible' => $req->person_responsible,
                            'updated_at' => Carbon::now()
                        ]);
                }
            }

            Alert::success('Success');

            return redirect(route('activity.report.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function activity_report_destroy($id)
    {
        try {
            $check = DB::table('activity_report')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('activity report not found');
                return back();
            }

            DB::table('activity_report')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('activity.report.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function activity_report_export()
    {
        $name = 'activity_report-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new ActivityReportExport, $name);
    }

    // Building Management
    public function building_management_index()
    {
        $data['building_management'] = DB::table('building_management')->get();
        $data['building_management_amount'] = DB::table('building_management')->count();

        return view('admin.building_management.index', $data);
    }

    public function building_management_create()
    {

        return view('admin.building_management.create');
    }

    public function building_management_store(Request $req)
    {
        $req->validate([
            'building_code' => 'required',
            'building_name' => 'required',
            'condition' => 'required',
            'picture' => 'required|max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            $extFile = $req->picture->getClientOriginalExtension();
            $namaFile = 'building-' . time() . "." . $extFile;
            $path = $req->picture->move('building', $namaFile);

            DB::table('building_management')->insert([
                'building_code' => $req->building_code,
                'building_name' => $req->building_name,
                'condition' => $req->condition,
                'picture' => $path,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('building.management.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function building_management_edit($id)
    {
        $data['building_management'] = DB::table('building_management')
            ->where('id', $id)
            ->first();

        return view('admin.building_management.edit', $data);
    }

    public function building_management_update(Request $req, $id)
    {
        $req->validate([
            'building_code' => 'required',
            'building_name' => 'required',
            'condition' => 'required',
            'picture' => 'max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            if ($req->hasFile('picture')) {
                $extFile = $req->picture->getClientOriginalExtension();
                $namaFile = 'building-' . time() . "." . $extFile;
                $path = $req->picture->move('building', $namaFile);

                DB::table('building_management')
                    ->where('id', $id)
                    ->update([
                        'building_code' => $req->building_code,
                        'building_name' => $req->building_name,
                        'condition' => $req->condition,
                        'picture' => $path,
                        'updated_at' => Carbon::now()
                    ]);
            } else {

                DB::table('building_management')
                    ->where('id', $id)
                    ->update([
                        'building_code' => $req->building_code,
                        'building_name' => $req->building_name,
                        'condition' => $req->condition,
                        'updated_at' => Carbon::now()
                    ]);
            }

            Alert::success('Success');

            return redirect(route('building.management.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function building_management_destroy($id)
    {
        try {
            $check = DB::table('building_management')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('building management not found');
                return back();
            }

            DB::table('building_management')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('building.management.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function building_management_export()
    {
        $name = 'building_management-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new BuildingManagementExport, $name);
    }
    // Facility Management
    public function facility_management_index()
    {
        $data['facility_management'] = DB::table('facility_management')->get();
        $data['facility_management_amount'] = DB::table('facility_management')->count();

        return view('admin.facility_management.index', $data);
    }

    public function facility_management_create()
    {

        return view('admin.facility_management.create');
    }

    public function facility_management_store(Request $req)
    {
        $req->validate([
            'facility_code' => 'required',
            'facility_name' => 'required',
            'condition' => 'required',
            'stock' => 'required',
            'picture' => 'required|max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            $extFile = $req->picture->getClientOriginalExtension();
            $namaFile = 'facility-' . time() . "." . $extFile;
            $path = $req->picture->move('facility', $namaFile);

            DB::table('facility_management')->insert([
                'facility_code' => $req->facility_code,
                'facility_name' => $req->facility_name,
                'condition' => $req->condition,
                'stock' => $req->stock,
                'picture' => $path,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('facility.management.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function facility_management_edit($id)
    {
        $data['facility_management'] = DB::table('facility_management')
            ->where('id', $id)
            ->first();

        return view('admin.facility_management.edit', $data);
    }

    public function facility_management_update(Request $req, $id)
    {
        $req->validate([
            'facility_code' => 'required',
            'facility_name' => 'required',
            'condition' => 'required',
            'picture' => 'max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            if ($req->hasFile('picture')) {
                $extFile = $req->picture->getClientOriginalExtension();
                $namaFile = 'facility-' . time() . "." . $extFile;
                $path = $req->picture->move('facility', $namaFile);

                DB::table('facility_management')
                    ->where('id', $id)
                    ->update([
                        'facility_code' => $req->facility_code,
                        'facility_name' => $req->facility_name,
                        'condition' => $req->condition,
                        'stock' => $req->stock,
                        'picture' => $path,
                        'updated_at' => Carbon::now()
                    ]);
            } else {

                DB::table('facility_management')
                    ->where('id', $id)
                    ->update([
                        'facility_code' => $req->facility_code,
                        'facility_name' => $req->facility_name,
                        'condition' => $req->condition,
                        'stock' => $req->stock,
                        'updated_at' => Carbon::now()
                    ]);
            }

            Alert::success('Success');

            return redirect(route('facility.management.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function facility_management_destroy($id)
    {
        try {
            $check = DB::table('facility_management')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('facility management not found');
                return back();
            }

            DB::table('facility_management')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('facility.management.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function facility_management_export()
    {
        $name = 'facility_management-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FacilityManagementExport, $name);
    }
    // Building Rental
    public function building_rental_index()
    {

        $data['building_rental'] = DB::table('building_rental')
            ->selectRaw('
                                        building_rental.id,
                                        building_rental.building_code,
                                        building_management.building_name,
                                        building_rental.start_date,
                                        building_rental.end_date,
                                        building_rental.rental_reasons,
                                        building_rental.number_of_people,
                                        building_rental.person_responsible,
                                        building_rental.telp,
                                        building_rental.status,
                                        building_rental.created_at,
                                        building_rental.updated_at
                                        ')
            ->leftJoin('building_management', 'building_rental.building_code', '=', 'building_management.building_code')
            ->orderByDesc('created_at')
            ->get();
        $data['building_rental_amount'] = DB::table('building_rental')->count();
        $data['building_rental_amount_status'] = [
            DB::table('building_rental')->where('status', 0)->count(),
            DB::table('building_rental')->where('status', 1)->count(),
            DB::table('building_rental')->where('status', 2)->count(),
            DB::table('building_rental')->where('status', 3)->count(),
        ];
        $data['rental_status'] = Config::get('enums.rental_status');
        if(session()->has('executive_id')) {
            $year_now = Carbon::now()->year;
            $month_name = ["Januari", "Feburari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $building_rental = DB::table('building_rental')
                        ->selectRaw('month(created_at) as month ,count(*) as amount')
                        ->groupByRaw('month(created_at)')
                        ->where('status', 3)
                        ->whereYear('created_at', $year_now)
                        ->get();
            
            $bur = [];
            foreach($building_rental as $de) {
                $bur['label'][] = $month_name[$de->month - 1];
                $bur['data'][] = (int) $de->amount;
            }
            $data['year'] = $year_now;
            $data['chart_building_rental'] = json_encode($bur);
        }
        return view('admin.building_rental.index', $data);
    }

    public function building_rental_create()
    {
        $data['building'] = DB::table('building_management')->get();
        $data['rental_status'] = Config::get('enums.rental_status');
        return view('admin.building_rental.create', $data);
    }

    public function building_rental_store(Request $req)
    {
        $req->validate([
            'building_code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'rental_reasons' => 'required',
            'number_of_people' => 'required',
            'person_responsible' => 'required',
            'telp' => 'required',
        ]);

        try {


            $check_building_exist = DB::table('building_management')
                ->where('building_code', $req->building_code)
                ->first();
            if (!$check_building_exist) {
                Alert::error('Building not found');
                return back();
            }

            $check_building_status = DB::table('building_rental')
                ->where('building_code', $req->building_code)
                ->where('status', '!=', 3)
                ->where('status', '!=', 2)
                ->count();

            if ($check_building_status > 0) {
                Alert::error('Building is still process rented');
                return back();
            }

            DB::table('building_rental')->insert([
                'building_code' => $req->building_code,
                'start_date' => $req->start_date,
                'end_date' => $req->end_date,
                'rental_reasons' => $req->rental_reasons,
                'number_of_people' => $req->number_of_people,
                'person_responsible' => $req->person_responsible,
                'telp' => $req->telp,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('building.rental.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function building_rental_edit($id)
    {
        $data['building'] = DB::table('building_management')->get();
        $data['building_rental'] = DB::table('building_rental')
            ->where('id', $id)
            ->first();
        $data['rental_status'] = Config::get('enums.rental_status');
       
        return view('admin.building_rental.edit', $data);
    }

    public function building_rental_update(Request $req, $id)
    {
        $req->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'rental_reasons' => 'required',
            'number_of_people' => 'required',
            'person_responsible' => 'required',
            'telp' => 'required',
        ]);

        try {
            if($req->status) {
                $building = DB::table('building_rental')
                         ->where('id', $id)
                         ->first();
               
                if($req->status == 1) {
                    DB::table('building_management')
                    ->where('building_code', $building->building_code)
                    ->update([
                        'is_rental' => 1,
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    DB::table('building_management')
                    ->where('building_code', $building->building_code)
                    ->update([
                        'is_rental' => 0,
                        'updated_at' => Carbon::now()
                    ]);
                }
                DB::table('building_rental')
                    ->where('id', $id)
                    ->update([
                        'start_date' => $req->start_date,
                        'end_date' => $req->end_date,
                        'rental_reasons' => $req->rental_reasons,
                        'number_of_people' => $req->number_of_people,
                        'person_responsible' => $req->person_responsible,
                        'telp' => $req->telp,
                        'status' => $req->status,
                        'updated_at' => Carbon::now()
                    ]);
                
            } else {
                DB::table('building_rental')
                    ->where('id', $id)
                    ->update([
                        'start_date' => $req->start_date,
                        'end_date' => $req->end_date,
                        'rental_reasons' => $req->rental_reasons,
                        'number_of_people' => $req->number_of_people,
                        'person_responsible' => $req->person_responsible,
                        'telp' => $req->telp,
                        'updated_at' => Carbon::now()
                    ]);
            }
            Alert::success('Success');

            return redirect(route('building.rental.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function building_rental_destroy($id)
    {
        try {
            $check = DB::table('building_rental')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('building rental not found');
                return back();
            }

            DB::table('building_rental')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('building.rental.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function building_rental_export()
    {
        $name = 'building_rental-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new BuildingRentalExport, $name);
    }
    // Facility Rental
    public function facility_rental_index()
    {

        $data['facility_rental'] = DB::table('facility_rental')
            ->selectRaw('
                                        facility_rental.id,
                                        facility_rental.facility_code,
                                        facility_rental.amount,
                                        facility_management.facility_name,
                                        facility_rental.start_date,
                                        facility_rental.end_date,
                                        facility_rental.rental_reasons,
                                        facility_rental.person_responsible,
                                        facility_rental.telp,
                                        facility_rental.status,
                                        facility_rental.created_at,
                                        facility_rental.updated_at
                                        ')
            ->leftJoin('facility_management', 'facility_rental.facility_code', '=', 'facility_management.facility_code')
            ->orderByDesc('created_at')
            ->get();
        $data['facility_rental_amount'] = DB::table('facility_rental')->count();
        $data['facility_rental_amount_status'] = [
            DB::table('facility_rental')->where('status', 0)->count(),
            DB::table('facility_rental')->where('status', 1)->count(),
            DB::table('facility_rental')->where('status', 2)->count(),
            DB::table('facility_rental')->where('status', 3)->count(),
        ];
        $data['rental_status'] = Config::get('enums.rental_status');
        if(session()->has('executive_id')) {
            $year_now = Carbon::now()->year;
            $month_name = ["Januari", "Feburari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $facility_rental = DB::table('facility_rental')
                        ->selectRaw('month(created_at) as month ,count(*) as amount')
                        ->groupByRaw('month(created_at)')
                        ->where('status', 3)
                        ->whereYear('created_at', $year_now)
                        ->get();
            
            $bur = [];
            foreach($facility_rental as $de) {
                $bur['label'][] = $month_name[$de->month - 1];
                $bur['data'][] = (int) $de->amount;
            }
            $data['year'] = $year_now;
            $data['chart_facility_rental'] = json_encode($bur);
        }
        return view('admin.facility_rental.index', $data);
    }

    public function facility_rental_create()
    {
        $data['facility'] = DB::table('facility_management')->get();
        $data['rental_status'] = Config::get('enums.rental_status');
        return view('admin.facility_rental.create', $data);
    }

    public function facility_rental_store(Request $req)
    {
        $req->validate([
            'facility_code' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'rental_reasons' => 'required',
            'person_responsible' => 'required',
            'telp' => 'required',
        ]);

        try {


            $check_facility_exist = DB::table('facility_management')
                ->where('facility_code', $req->facility_code)
                ->first();
            if (!$check_facility_exist) {
                Alert::error('facility not found');
                return back();
            }

            $check_facility_status = DB::table('facility_rental')
                ->where('facility_code', $req->facility_code)
                ->where('status', '!=', 3)
                ->where('status', '!=', 2)
                ->count();

            if ($check_facility_status > 0) {
                Alert::error('facility is still process rented');
                return back();
            }


            $total = $check_facility_exist->stock - $req->amount;

            if ($total < 0) {
                Alert::error('out of stock');
                return back();
            }

            DB::table('facility_management')
                ->where('facility_code', $req->facility_code)
                ->update([
                    'stock' => $total
                ]);

            DB::table('facility_rental')->insert([
                'facility_code' => $req->facility_code,
                'amount' => $req->amount,
                'start_date' => $req->start_date,
                'end_date' => $req->end_date,
                'rental_reasons' => $req->rental_reasons,
                'person_responsible' => $req->person_responsible,
                'telp' => $req->telp,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('facility.rental.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function facility_rental_edit($id)
    {
        $data['facility'] = DB::table('facility_management')->get();
        $data['facility_rental'] = DB::table('facility_rental')
            ->where('id', $id)
            ->first();
        $data['rental_status'] = Config::get('enums.rental_status');
        return view('admin.facility_rental.edit', $data);
    }

    public function facility_rental_update(Request $req, $id)
    {
        $req->validate([
            'amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'rental_reasons' => 'required',
            'person_responsible' => 'required',
            'telp' => 'required',
        ]);

        try {

            $facility_rental = DB::table('facility_rental')
                ->where('id', $id)
                ->first();
            $check_facility = DB::table('facility_management')
                ->where('facility_code', $facility_rental->facility_code)
                ->first();
            $total = $check_facility->stock - $req->amount;

            if ($total < 0) {
                Alert::error('out of stock');
                return back();
            }

            if ($req->status) {

                if ($req->status == 2 || $req->status == 3) {
                    $stock = $check_facility->stock + $facility_rental->amount;
                    DB::table('facility_management')
                        ->where('facility_code', $facility_rental->facility_code)
                        ->update([
                            'stock' => $stock
                        ]);
                }

                DB::table('facility_rental')
                    ->where('id', $id)
                    ->update([
                        'start_date' => $req->start_date,
                        'end_date' => $req->end_date,
                        'rental_reasons' => $req->rental_reasons,
                        'person_responsible' => $req->person_responsible,
                        'telp' => $req->telp,
                        'status' => $req->status,
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                DB::table('facility_rental')
                    ->where('id', $id)
                    ->update([
                        'start_date' => $req->start_date,
                        'end_date' => $req->end_date,
                        'rental_reasons' => $req->rental_reasons,
                        'person_responsible' => $req->person_responsible,
                        'telp' => $req->telp,
                        'updated_at' => Carbon::now()
                    ]);
            }

            Alert::success('Success');

            return redirect(route('facility.rental.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function facility_rental_destroy($id)
    {
        try {
            $check = DB::table('facility_rental')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('facility rental not found');
                return back();
            }

            DB::table('facility_rental')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('facility.rental.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function facility_rental_export()
    {
        $name = 'facility_rental-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FacilityRentalExport, $name);
    }
    // Facility Compensation
    public function facility_compensation_index()
    {

        $data['facility_compensation'] = DB::table('facility_compensation')
            ->orderByDesc('created_at')
            ->get();
        $data['facility_compensation_amount'] = DB::table('facility_compensation')->count();
        $data['facility_compensation_amount_status'] = [
                DB::table('facility_compensation')->where('status', 0)->count(),
                DB::table('facility_compensation')->where('status', 1)->count(),
                DB::table('facility_compensation')->where('status', 2)->count(),
            ];
        $data['compensation_status'] = Config::get('enums.compensation_status');
        return view('admin.facility_compensation.index', $data);
    }

    public function facility_compensation_create()
    {
        $data['compensation_status'] = Config::get('enums.compensation_status');
        return view('admin.facility_compensation.create', $data);
    }

    public function facility_compensation_store(Request $req)
    {
        $req->validate([
            'facility_name' => 'required',
            'amount' => 'required',
            'amount_compensation' => 'required',
            'person_responsible' => 'required',
            'telp' => 'required',
            'picture' => 'required|max:1000|file|mimes:png,jpeg,jpg',
        ]);

        try {

            $extFile = $req->picture->getClientOriginalExtension();
            $namaFile = 'picture-' . time() . "." . $extFile;
            $path = $req->picture->move('facility_compensation', $namaFile);

            DB::table('facility_compensation')->insert([
                'facility_name' => $req->facility_name,
                'amount' => $req->amount,
                'amount_compensation' => $req->amount_compensation,
                'person_responsible' => $req->person_responsible,
                'telp' => $req->telp,
                'picture' => $path,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('facility.compensation.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function facility_compensation_edit($id)
    {
        $data['facility_compensation'] = DB::table('facility_compensation')
            ->where('id', $id)
            ->first();
        $data['compensation_status'] = Config::get('enums.compensation_status');
        return view('admin.facility_compensation.edit', $data);
    }

    public function facility_compensation_update(Request $req, $id)
    {
        $req->validate([
            'facility_name' => 'required',
            'amount' => 'required',
            'amount_compensation' => 'required',
            'person_responsible' => 'required',
            'telp' => 'required',
            'picture' => 'max:1000|file|mimes:png,jpeg,jpg',

        ]);

        try {

            if ($req->hasFile('picture')) {
                $extFile = $req->picture->getClientOriginalExtension();
                $namaFile = 'picture-' . time() . "." . $extFile;
                $path = $req->picture->move('facility_compensation', $namaFile);
                if ($req->status) {
                    
                    DB::table('facility_compensation')
                        ->where('id', $id)
                        ->update([
                            'facility_name' => $req->facility_name,
                            'amount' => $req->amount,
                            'amount_compensation' => $req->amount_compensation,
                            'person_responsible' => $req->person_responsible,
                            'telp' => $req->telp,
                            'picture' => $path,
                            'status' => $req->status,
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('facility_compensation')
                        ->where('id', $id)
                        ->update([
                            'facility_name' => $req->facility_name,
                            'amount' => $req->amount,
                            'amount_compensation' => $req->amount_compensation,
                            'person_responsible' => $req->person_responsible,
                            'telp' => $req->telp,
                            'picture' => $path,
                            'updated_at' => Carbon::now()
                        ]);
                }
                
            } else {
                if ($req->status) {

                    DB::table('facility_compensation')
                        ->where('id', $id)
                        ->update([
                            'facility_name' => $req->facility_name,
                            'amount' => $req->amount,
                            'amount_compensation' => $req->amount_compensation,
                            'person_responsible' => $req->person_responsible,
                            'telp' => $req->telp,
                            'status' => $req->status,
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('facility_compensation')
                        ->where('id', $id)
                        ->update([
                            'facility_name' => $req->facility_name,
                            'amount' => $req->amount,
                            'amount_compensation' => $req->amount_compensation,
                            'person_responsible' => $req->person_responsible,
                            'telp' => $req->telp,
                            'updated_at' => Carbon::now()
                        ]);
                }
            }


            Alert::success('Success');

            return redirect(route('facility.compensation.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function facility_compensation_destroy($id)
    {
        try {
            $check = DB::table('facility_compensation')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('building rental not found');
                return back();
            }

            DB::table('facility_compensation')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('facility.compensation.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function facility_compensation_export()
    {
        $name = 'facility_compensation-';
        $name .= Carbon::now();
        $name .= '.xlsx';
        return Excel::download(new FacilityCompensationExport, $name);
    }
    // User Executive
    public function user_executive_index()
    {
        $data['executive'] = DB::table('executive')->get();
        return view('admin.user-executive.index', $data);
    }

    public function user_executive_create()
    {

        return view('admin.user-executive.create');
    }

    public function user_executive_store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'username' => 'required|unique:executive,username',
            'email' => 'required|email|unique:executive,email',
            'phone_number' => 'required',
            'picture' => 'max:1000|file|image',
            'password' => 'required|same:password_confirm',
            'password_confirm' => 'required|same:password',
            'address' => 'required',
        ]);
        try {
            if ($req->hasFile('picture')) {
                $extFile = $req->picture->getClientOriginalExtension();
                $namaFile = 'executive-' . time() . "." . $extFile;
                $path = $req->picture->move('img/executive', $namaFile);
                $exe = [
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'phone_number' => $req->phone_number,
                    'password' => Hash::make($req->password),
                    'address' => $req->address,
                    'picture' => $path,
                    'created_at' => Carbon::now()
                ];
            } else {
                $exe = [
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'phone_number' => $req->phone_number,
                    'password' => Hash::make($req->password),
                    'address' => $req->address,
                    'created_at' => Carbon::now()
                ];
            }
            DB::table('executive')->insert($exe);

            Alert::success('Success');

            return redirect(route('user.executive.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_executive_edit($id)
    {
        $data['executive'] = DB::table('executive')
            ->where('id', $id)
            ->first();
        return view('admin.user-executive.edit', $data);
    }

    public function user_executive_update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'username' => 'required|unique:executive,username,' . $id . ',id',
            'email' => 'required|email|unique:executive,email,' . $id . ',id',
            'phone_number' => 'required',
            'address' => 'required',
            'picture' => 'max:1000|file|image',
        ]);
        try {

            if ($req->hasFile('picture')) {



                $extFile = $req->picture->getClientOriginalExtension();
                $namaFile = 'executive-' . time() . "." . $extFile;
                $path = $req->picture->move('img/executive', $namaFile);
                $exe = [
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'phone_number' => $req->phone_number,
                    'address' => $req->address,
                    'picture' => $path,
                    'created_at' => Carbon::now()
                ];
            } else {
                $exe = [
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'phone_number' => $req->phone_number,
                    'address' => $req->address,
                    'updated_at' => Carbon::now()
                ];
            }

            DB::table('executive')
                ->where('id', $id)
                ->update($exe);

            Alert::success('Success');
            if (session('executive_id') == $id) {

                return redirect(route('user.executive.profile'));
            } else {

                return redirect(route('user.executive.index'));
            }
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_executive_pass($id)
    {
        $data['executive'] = DB::table('executive')
            ->where('id', $id)
            ->first();
        return view('admin.user-executive.pass', $data);
    }

    public function user_executive_pass_act(Request $req, $id)
    {
        $req->validate([
            'password' => 'required|same:password_confirm',
            'password_confirm' => 'required|same:password',
        ]);
        try {

            DB::table('executive')
                ->where('id', $id)
                ->update([

                    'password' => Hash::make($req->password),
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');
            if (session('executive_id') == $id) {

                return redirect(route('user.executive.profile'));
            } else {

                return redirect(route('user.executive.index'));
            }
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_executive_destroy($id)
    {
        try {

            $check = DB::table('executive')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('User executive not found');
                return back();
            }

            DB::table('executive')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('user.executive.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }
    public function user_executive_profile()
    {
        $id = session('executive_id');
        $data['profile'] = DB::table('executive')
            ->where('id', $id)
            ->first();
        return view('admin.user-executive.profile', $data);
    }
    // User Admin
    public function user_admin_index()
    {
        $data['admin'] = DB::table('admin')->get();
        return view('admin.user-admin.index', $data);
    }

    public function user_admin_create()
    {

        return view('admin.user-admin.create');
    }

    public function user_admin_store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'username' => 'required|unique:admin,username',
            'email' => 'required|email|unique:admin,email',
            'phone_number' => 'required',
            'password' => 'required|same:password_confirm',
            'password_confirm' => 'required|same:password',
            'address' => 'required',
        ]);
        try {

            DB::table('admin')->insert([
                'name' => $req->name,
                'username' => $req->username,
                'email' => $req->email,
                'phone_number' => $req->phone_number,
                'password' => Hash::make($req->password),
                'address' => $req->address,
                'created_at' => Carbon::now()
            ]);

            Alert::success('Success');

            return redirect(route('user.admin.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_admin_edit($id)
    {
        $data['admin'] = DB::table('admin')
            ->where('id', $id)
            ->first();
        return view('admin.user-admin.edit', $data);
    }

    public function user_admin_update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'username' => 'required|unique:admin,username,' . $id . ',id',
            'email' => 'required|email|unique:admin,email,' . $id . ',id',
            'phone_number' => 'required',
            'address' => 'required',
        ]);
        try {

            DB::table('admin')
                ->where('id', $id)
                ->update([
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'phone_number' => $req->phone_number,
                    'address' => $req->address,
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('user.admin.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_admin_pass($id)
    {
        $data['admin'] = DB::table('admin')
            ->where('id', $id)
            ->first();
        return view('admin.user-admin.pass', $data);
    }

    public function user_admin_pass_act(Request $req, $id)
    {
        $req->validate([
            'password' => 'required|same:password_confirm',
            'password_confirm' => 'required|same:password',
        ]);
        try {

            DB::table('admin')
                ->where('id', $id)
                ->update([

                    'password' => Hash::make($req->password),
                    'updated_at' => Carbon::now()
                ]);

            Alert::success('Success');

            return redirect(route('user.admin.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_admin_destroy($id)
    {
        try {

            $check = DB::table('admin')
                ->where('id', $id)
                ->first();
            if (!$check) {
                Alert::error('User admin not found');
                return back();
            }

            DB::table('admin')
                ->where('id', $id)
                ->delete();

            Alert::success('Success');

            return redirect(route('user.admin.index'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function user_admin_profile()
    {
        $id = session('admin_id');
        $data['profile'] = DB::table('admin')
            ->where('id', $id)
            ->first();
        return view('admin.user-admin.profile', $data);
    }
}
