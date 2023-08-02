<?php

namespace App\Http\Controllers;

use App\Http\Requests\BriefingHybridRequest;
use App\Http\Requests\BriefingOnlineRequest;
use App\Http\Requests\BriefingPersonRequest;
use App\Http\Requests\BriefingRequest;
use App\Mail\NewBriefing;
use App\Models\Category;
use App\Models\Briefing;
use App\Models\BriefingHybrid;
use App\Models\BriefingOnline;
use App\Models\BriefingPerson;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BriefingController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $briefings = Briefing::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('briefings.index', compact('briefings', 'query'));
        }

        $briefings = Briefing::orderBy('name', 'ASC')->paginate(10);

        return view('briefings.index', compact('briefings', 'query'));
    }

    public function indexFront()
    {
        return view('front.briefings.index');
    }

    public function create($type, $front = false)
    {
        $briefing = new Briefing();

        if ($front) {
            if ($type == 'online') {
                return view('front.briefings.form-online', compact('briefing'));
            }
            if ($type == 'person') {
                return view('front.briefings.form-person', compact('briefing'));
            }
            if ($type == 'hybrid') {
                return view('front.briefings.form-hybrid', compact('briefing'));
            }
        }

        if ($type == 'online') {
            return view('briefings.form-online', compact('briefing'));
        }
        if ($type == 'person') {
            return view('briefings.form-person', compact('briefing'));
        }
        if ($type == 'hybrid') {
            return view('briefings.form-hybrid', compact('briefing'));
        }
    }

    public function createFront($type)
    {
        return $this->create($type, true);
    }

    public function store(Request $request)
    {
        Briefing::create($request->validated());

        return redirect()->route('briefings.index');
    }

    public function storeOnline(BriefingOnlineRequest $request, $front = false)
    {
        $params = $request->validated();
        $params['type_event'] = 1;

        if (empty($params['start_date_mount'])) {
            unset($params['start_date_mount']);
        }

        if (empty($params['end_date_mount'])) {
            unset($params['end_date_mount']);
        }

        if (empty($params['start_date_rehearsal'])) {
            unset($params['start_date_rehearsal']);
        }

        if (empty($params['end_date_rehearsal'])) {
            unset($params['end_date_rehearsal']);
        }

        if (empty($params['start_date_event'])) {
            unset($params['start_date_event']);
        }

        if (empty($params['end_date_event'])) {
            unset($params['end_date_event']);
        }

        if (empty($params['agency_production'])) {
            $params['agency_production'] = 0;
        }

        if (empty($params['agency_criation'])) {
            $params['agency_criation'] = 0;
        }

        if (empty($params['agency_logistic'])) {
            $params['agency_logistic'] = 0;
        }

        if (empty($params['speaker'])) {
            $params['speaker'] = 0;
        }

        if (empty($params['direction'])) {
            $params['direction'] = 0;
        }

        if (empty($params['rehearsal'])) {
            $params['rehearsal'] = 0;
        }

        if (empty($params['recording'])) {
            $params['recording'] = 0;
        }

        if (empty($params['translation'])) {
            $params['translation'] = 0;
        }

        if (empty($params['dedicated_internet'])) {
            $params['dedicated_internet'] = 0;
        }

        if (empty($params['generator'])) {
            $params['generator'] = 0;
        }

        DB::beginTransaction();

        try {
            $briefing = Briefing::create($params);
            $briefing->online()->create($params);

            DB::commit();

            if ($front) {
                Mail::to('contato@iseventos.com.br')
                    ->cc('alessandra@iseventos.com.br')
                    ->cc('luana@iseventos.com.br')
                    ->cc('igor@iseventos.com.br')
                    ->send(new NewBriefing($briefing));

                return redirect()->route('front.briefings.index')->with('success', 'Briefing enviado com sucesso!');
            }

            return redirect()->route('briefings.index');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function storeOnlineFront(BriefingOnlineRequest $request)
    {
        return $this->storeOnline($request, true);
    }

    public function storePerson(BriefingPersonRequest $request, $front = false)
    {
        $params = $request->validated();
        $params['type_event'] = 2;

        if (empty($params['start_date_mount'])) {
            unset($params['start_date_mount']);
        }

        if (empty($params['end_date_mount'])) {
            unset($params['end_date_mount']);
        }

        if (empty($params['start_date_rehearsal'])) {
            unset($params['start_date_rehearsal']);
        }

        if (empty($params['end_date_rehearsal'])) {
            unset($params['end_date_rehearsal']);
        }

        if (empty($params['start_date_event'])) {
            unset($params['start_date_event']);
        }

        if (empty($params['end_date_event'])) {
            unset($params['end_date_event']);
        }

        if (empty($params['agency_production'])) {
            $params['agency_production'] = 0;
        }

        if (empty($params['agency_criation'])) {
            $params['agency_criation'] = 0;
        }

        if (empty($params['agency_logistic'])) {
            $params['agency_logistic'] = 0;
        }

        if (empty($params['armchair'])) {
            $params['armchair'] = 0;
        }

        if (empty($params['pulpit'])) {
            $params['pulpit'] = 0;
        }

        if (empty($params['table'])) {
            $params['table'] = 0;
        }

        if (empty($params['lounge'])) {
            $params['lounge'] = 0;
        }

        if (empty($params['lighting_decorative'])) {
            $params['lighting_decorative'] = 0;
        }

        if (empty($params['lighting_foyer'])) {
            $params['lighting_foyer'] = 0;
        }

        if (empty($params['lighting_restaurant'])) {
            $params['lighting_restaurant'] = 0;
        }

        if (empty($params['lighting_stage'])) {
            $params['lighting_stage'] = 0;
        }

        if (empty($params['lighting_effects'])) {
            $params['lighting_effects'] = 0;
        }

        if (empty($params['sound_room'])) {
            $params['sound_room'] = 0;
        }

        if (empty($params['sound_foyer'])) {
            $params['sound_foyer'] = 0;
        }

        if (empty($params['sound_restaurant'])) {
            $params['sound_restaurant'] = 0;
        }

        if (empty($params['translation'])) {
            $params['translation'] = 0;
        }

        DB::beginTransaction();

        try {
            $briefing = Briefing::create($params);
            $briefingPerson = $briefing->person()->create($params);

            if (!empty($params['room_name'])) {
                foreach ($params['room_name'] as $index => $roomName) {
                    if (!empty($roomName)) {
                        $briefingPerson->rooms()->create([
                            'name' => $roomName,
                            'room_format' => $params['room_format'][$index],
                            'comments' => $params['room_description'][$index],
                        ]);
                    }
                }
            }

            DB::commit();

            if ($front) {
                Mail::to('contato@iseventos.com.br')
                    ->cc('alessandra@iseventos.com.br')
                    ->cc('luana@iseventos.com.br')
                    ->cc('igor@iseventos.com.br')
                    ->send(new NewBriefing($briefing));

                return redirect()->route('front.briefings.index')->with('success', 'Briefing enviado com sucesso!');
            }

            return redirect()->route('briefings.index');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function storePersonFront(BriefingPersonRequest $request)
    {
        return $this->storePerson($request, true);
    }

    public function storeHybrid(BriefingHybridRequest $request, $front = false)
    {
        $params = $request->validated();
        $params['type_event'] = 3;

        if (empty($params['start_date_mount'])) {
            unset($params['start_date_mount']);
        }

        if (empty($params['end_date_mount'])) {
            unset($params['end_date_mount']);
        }

        if (empty($params['start_date_rehearsal'])) {
            unset($params['start_date_rehearsal']);
        }

        if (empty($params['end_date_rehearsal'])) {
            unset($params['end_date_rehearsal']);
        }

        if (empty($params['start_date_event'])) {
            unset($params['start_date_event']);
        }

        if (empty($params['end_date_event'])) {
            unset($params['end_date_event']);
        }

        if (empty($params['agency_production'])) {
            $params['agency_production'] = 0;
        }

        if (empty($params['agency_criation'])) {
            $params['agency_criation'] = 0;
        }

        if (empty($params['agency_logistic'])) {
            $params['agency_logistic'] = 0;
        }

        if (empty($params['armchair'])) {
            $params['armchair'] = 0;
        }

        if (empty($params['pulpit'])) {
            $params['pulpit'] = 0;
        }

        if (empty($params['table'])) {
            $params['table'] = 0;
        }

        if (empty($params['lounge'])) {
            $params['lounge'] = 0;
        }

        if (empty($params['lighting_decorative'])) {
            $params['lighting_decorative'] = 0;
        }

        if (empty($params['lighting_foyer'])) {
            $params['lighting_foyer'] = 0;
        }

        if (empty($params['lighting_restaurant'])) {
            $params['lighting_restaurant'] = 0;
        }

        if (empty($params['lighting_stage'])) {
            $params['lighting_stage'] = 0;
        }

        if (empty($params['lighting_effects'])) {
            $params['lighting_effects'] = 0;
        }

        if (empty($params['sound_room'])) {
            $params['sound_room'] = 0;
        }

        if (empty($params['sound_foyer'])) {
            $params['sound_foyer'] = 0;
        }

        if (empty($params['sound_restaurant'])) {
            $params['sound_restaurant'] = 0;
        }

        if (empty($params['translation'])) {
            $params['translation'] = 0;
        }

        if (empty($params['speaker'])) {
            $params['speaker'] = 0;
        }

        if (empty($params['direction'])) {
            $params['direction'] = 0;
        }

        if (empty($params['speaker_studio'])) {
            $params['speaker_studio'] = 0;
        }

        if (empty($params['rehearsal'])) {
            $params['rehearsal'] = 0;
        }

        if (empty($params['recording'])) {
            $params['recording'] = 0;
        }

        if (empty($params['teleprompter'])) {
            $params['teleprompter'] = 0;
        }

        if (empty($params['ipad'])) {
            $params['ipad'] = 0;
        }

        DB::beginTransaction();

        try {
            $briefing = Briefing::create($params);
            $briefingHybrid = $briefing->hybrid()->create($params);

            if (!empty($params['room_name'])) {
                foreach ($params['room_name'] as $index => $roomName) {
                    if (!empty($roomName)) {
                        $briefingHybrid->rooms()->create([
                            'name' => $roomName,
                            'room_format' => $params['room_format'][$index],
                            'comments' => $params['room_description'][$index],
                        ]);
                    }
                }
            }

            DB::commit();

            if ($front) {
                Mail::to('contato@iseventos.com.br')
                    ->cc('alessandra@iseventos.com.br')
                    ->cc('luana@iseventos.com.br')
                    ->cc('igor@iseventos.com.br')
                    ->send(new NewBriefing($briefing));

                return redirect()->route('front.briefings.index')->with('success', 'Briefing enviado com sucesso!');
            }

            return redirect()->route('briefings.index');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function storeHybridFront(BriefingHybridRequest $request)
    {
        return $this->storeHybrid($request, true);
    }

    public function edit(Briefing $briefing, $showMode = false)
    {
        if ($briefing->type_event == '1') {
            return view('briefings.form-online', compact('briefing', 'showMode'));
        }
        if ($briefing->type_event == '2') {
            return view('briefings.form-person', compact('briefing', 'showMode'));
        }
        if ($briefing->type_event == '3') {
            return view('briefings.form-hybrid', compact('briefing', 'showMode'));
        }
    }

    public function updateOnline($id, BriefingOnlineRequest $request)
    {
        $params = $request->validated();

        if (empty($params['start_date_mount'])) {
            unset($params['start_date_mount']);
        }

        if (empty($params['end_date_mount'])) {
            unset($params['end_date_mount']);
        }

        if (empty($params['start_date_rehearsal'])) {
            unset($params['start_date_rehearsal']);
        }

        if (empty($params['end_date_rehearsal'])) {
            unset($params['end_date_rehearsal']);
        }

        if (empty($params['start_date_event'])) {
            unset($params['start_date_event']);
        }

        if (empty($params['end_date_event'])) {
            unset($params['end_date_event']);
        }

        if (empty($params['agency_production'])) {
            $params['agency_production'] = 0;
        }

        if (empty($params['agency_criation'])) {
            $params['agency_criation'] = 0;
        }

        if (empty($params['agency_logistic'])) {
            $params['agency_logistic'] = 0;
        }

        if (empty($params['speaker'])) {
            $params['speaker'] = 0;
        }

        if (empty($params['direction'])) {
            $params['direction'] = 0;
        }

        if (empty($params['rehearsal'])) {
            $params['rehearsal'] = 0;
        }

        if (empty($params['recording'])) {
            $params['recording'] = 0;
        }

        if (empty($params['translation'])) {
            $params['translation'] = 0;
        }

        if (empty($params['dedicated_internet'])) {
            $params['dedicated_internet'] = 0;
        }

        if (empty($params['generator'])) {
            $params['generator'] = 0;
        }

        DB::beginTransaction();

        try {
            $briefingOnline = BriefingOnline::find($id);
            $briefingOnline->update($params);

            $briefing = Briefing::find($briefingOnline->briefing_id);
            $briefing->update($params);

            DB::commit();

            return redirect()->route('briefings.index');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function updatePerson($id, BriefingPersonRequest $request)
    {
        $params = $request->validated();

        if (empty($params['start_date_mount'])) {
            unset($params['start_date_mount']);
        }

        if (empty($params['end_date_mount'])) {
            unset($params['end_date_mount']);
        }

        if (empty($params['start_date_rehearsal'])) {
            unset($params['start_date_rehearsal']);
        }

        if (empty($params['end_date_rehearsal'])) {
            unset($params['end_date_rehearsal']);
        }

        if (empty($params['start_date_event'])) {
            unset($params['start_date_event']);
        }

        if (empty($params['end_date_event'])) {
            unset($params['end_date_event']);
        }

        if (empty($params['agency_production'])) {
            $params['agency_production'] = 0;
        }

        if (empty($params['agency_criation'])) {
            $params['agency_criation'] = 0;
        }

        if (empty($params['agency_logistic'])) {
            $params['agency_logistic'] = 0;
        }

        if (empty($params['armchair'])) {
            $params['armchair'] = 0;
        }

        if (empty($params['pulpit'])) {
            $params['pulpit'] = 0;
        }

        if (empty($params['table'])) {
            $params['table'] = 0;
        }

        if (empty($params['lounge'])) {
            $params['lounge'] = 0;
        }

        if (empty($params['lighting_decorative'])) {
            $params['lighting_decorative'] = 0;
        }

        if (empty($params['lighting_foyer'])) {
            $params['lighting_foyer'] = 0;
        }

        if (empty($params['lighting_restaurant'])) {
            $params['lighting_restaurant'] = 0;
        }

        if (empty($params['lighting_stage'])) {
            $params['lighting_stage'] = 0;
        }

        if (empty($params['lighting_effects'])) {
            $params['lighting_effects'] = 0;
        }

        if (empty($params['sound_room'])) {
            $params['sound_room'] = 0;
        }

        if (empty($params['sound_foyer'])) {
            $params['sound_foyer'] = 0;
        }

        if (empty($params['sound_restaurant'])) {
            $params['sound_restaurant'] = 0;
        }

        if (empty($params['translation'])) {
            $params['translation'] = 0;
        }

        DB::beginTransaction();

        try {

            $briefingPerson = BriefingPerson::find($id);
            $briefingPerson->update($params);

            $briefing = Briefing::find($briefingPerson->briefing_id);
            $briefing->update($params);

            $briefingPerson->rooms()->delete();

            if (!empty($params['room_name'])) {
                foreach ($params['room_name'] as $index => $roomName) {
                    if (!empty($roomName)) {
                        $briefingPerson->rooms()->create([
                            'name' => $roomName,
                            'room_format' => $params['room_format'][$index],
                            'comments' => $params['room_description'][$index],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('briefings.index');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function updateHybrid($id, BriefingHybridRequest $request)
    {
        $params = $request->validated();

        if (empty($params['start_date_mount'])) {
            unset($params['start_date_mount']);
        }

        if (empty($params['end_date_mount'])) {
            unset($params['end_date_mount']);
        }

        if (empty($params['start_date_rehearsal'])) {
            unset($params['start_date_rehearsal']);
        }

        if (empty($params['end_date_rehearsal'])) {
            unset($params['end_date_rehearsal']);
        }

        if (empty($params['start_date_event'])) {
            unset($params['start_date_event']);
        }

        if (empty($params['end_date_event'])) {
            unset($params['end_date_event']);
        }

        if (empty($params['agency_production'])) {
            $params['agency_production'] = 0;
        }

        if (empty($params['agency_criation'])) {
            $params['agency_criation'] = 0;
        }

        if (empty($params['agency_logistic'])) {
            $params['agency_logistic'] = 0;
        }

        if (empty($params['armchair'])) {
            $params['armchair'] = 0;
        }

        if (empty($params['pulpit'])) {
            $params['pulpit'] = 0;
        }

        if (empty($params['table'])) {
            $params['table'] = 0;
        }

        if (empty($params['lounge'])) {
            $params['lounge'] = 0;
        }

        if (empty($params['lighting_decorative'])) {
            $params['lighting_decorative'] = 0;
        }

        if (empty($params['lighting_foyer'])) {
            $params['lighting_foyer'] = 0;
        }

        if (empty($params['lighting_restaurant'])) {
            $params['lighting_restaurant'] = 0;
        }

        if (empty($params['lighting_stage'])) {
            $params['lighting_stage'] = 0;
        }

        if (empty($params['lighting_effects'])) {
            $params['lighting_effects'] = 0;
        }

        if (empty($params['sound_room'])) {
            $params['sound_room'] = 0;
        }

        if (empty($params['sound_foyer'])) {
            $params['sound_foyer'] = 0;
        }

        if (empty($params['sound_restaurant'])) {
            $params['sound_restaurant'] = 0;
        }

        if (empty($params['translation'])) {
            $params['translation'] = 0;
        }

        if (empty($params['speaker'])) {
            $params['speaker'] = 0;
        }

        if (empty($params['direction'])) {
            $params['direction'] = 0;
        }

        if (empty($params['speaker_studio'])) {
            $params['speaker_studio'] = 0;
        }

        if (empty($params['rehearsal'])) {
            $params['rehearsal'] = 0;
        }

        if (empty($params['recording'])) {
            $params['recording'] = 0;
        }

        if (empty($params['teleprompter'])) {
            $params['teleprompter'] = 0;
        }

        if (empty($params['ipad'])) {
            $params['ipad'] = 0;
        }

        DB::beginTransaction();

        try {

            $briefingHybrid = BriefingHybrid::find($id);
            $briefingHybrid->update($params);

            $briefing = Briefing::find($briefingHybrid->briefing_id);
            $briefing->update($params);

            $briefingHybrid->rooms()->delete();

            if (!empty($params['room_name'])) {
                foreach ($params['room_name'] as $index => $roomName) {
                    if (!empty($roomName)) {
                        $briefingHybrid->rooms()->create([
                            'name' => $roomName,
                            'room_format' => $params['room_format'][$index],
                            'comments' => $params['room_description'][$index],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('briefings.index');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function destroy(Briefing $briefing)
    {
        if ($briefing->type_event == '1') {
            $briefingOnline = BriefingOnline::where('briefing_id', $briefing->id)->first();
            $briefingOnline->delete();
            $briefing->delete();
        }

        if ($briefing->type_event == '2') {
            $briefingPerson = BriefingPerson::where('briefing_id', $briefing->id)->first();
            $briefingPerson->delete();
            $briefing->delete();
        }

        if ($briefing->type_event == '3') {
            $briefingHybrid = BriefingHybrid::where('briefing_id', $briefing->id)->first();
            $briefingHybrid->delete();
            $briefing->delete();
        }

        return redirect()->route('briefings.index');
    }

    public function show(Briefing $briefing)
    {
        return $this->edit($briefing, true);
    }
}
