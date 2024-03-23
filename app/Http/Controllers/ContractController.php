<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ProjectCode;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Arr;
Use Alert;

class ContractController extends Controller
{

    public function storeContract (Request $request) {
        try {
            $dateArray = explode(' - ', $request->dateRange);
            $startDate = Carbon::createFromFormat('d/m/Y', $dateArray[0]);
            $endDate = Carbon::createFromFormat('d/m/Y', $dateArray[1]);

            $cont = Contract::create([
                'by' => $request->user()->id,
                'book_num' => $request->cont_bnum,
                'title' => $request->cont_title,
                'party' => $request->cont_party,
                'budget' => $request->cont_budget ?? 0,
                'time_range' => $request->dateRange,
                'note' => $request->cont_note,
                'files' => json_encode($request->cont_files),
                'type' => $request->contact_type,
                'submit_by' => json_encode([$request->user()->id]),
                'project_code' => $request->proj_code ?? '',
            ]);

            $cont->recurring = json_encode([
                'freq' => 'yearly',
                'interval' => $request->recur_y,
                'count' => $request->recur_count ?? '', // How many occurrences will be generated.
                'bymonth' => $request->recur_m,  // the months to apply the recurrence to.
                'bymonthday' => $request->recur_d, // the month days to apply the recurrence to.
                'dtstart' => $startDate, // will also accept '20120201T103000'
                'until' => $endDate, // will also accept '20120201'
            ]);

            $cont->save();


            return redirect()->back()->with(['success' => "Success!"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function updateContract($cid, Request $request) {
        $contract = Contract::find($cid);
        try {
            $contract->update([
                'title' => $request->cont_title,
                'party' => $request->cont_party,
                'time_range' => $request->dateRange,
                'note' => $request->cont_note,
            ]);

            if ($request->recur ?? 0) {
                $contract->recurring = json_encode([
                    'enable' => $request->recur,
                    'recur_date' => json_encode($request->recurring),
                ]);

                $contract->save();
            }


            return redirect()->route('contTable');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function filepondUpload (Request $request) {
        if ($request->hasFile('cont_files')) {
            $file = $request->file('cont_files');
            $file_name = '';
            $file_name = time() . '_' . md5(uniqid(rand(), true)) . '.' . $file[0]->getClientOriginalExtension();
            $folder = 'contract/';
            $file[0]->storeAs($folder , $file_name);

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
            ]);

            return $file_name;
        }
        return '';
    }

    public function filepondDelete (Request $request) {
        $tmp_file = TemporaryFile::where('folder', $request->getContent())->first();
        if ($tmp_file) {
            Storage::deleteDirectory($tmp_file->folder);
            $tmp_file->delete();
        }

        return response()->noContent();
    }

    public function contractCalendar(Request $request) {
        if ($request->user()->hasRole('admin')) {
            $contracts = Contract::all();
        } else {
            $contracts = Contract::where('by', $request->user()->id)->get();
        }
        $events = [];

        $eventColor = [
            'creditor' => '#6633C6',
            'debtor' => '#0063FF',
            'outdoor' => '#5AA136',
        ];
        $num = 1;
        foreach ($contracts as $index => $contract) {
            $dateArray = explode(' - ', $contract->time_range);
            $startDate = Carbon::createFromFormat('d/m/Y', $dateArray[0]);
            $endDate = Carbon::createFromFormat('d/m/Y', $dateArray[1]);
            if ($contract->recurring) {
                // $event = [
                //     'id' => $contract->book_num,
                //     'groupId' => $contract->type,
                //     'title' => $contract->title,
                //     'description' => $contract->note ?? '',
                //     'party' => $contract->party ?? '',
                //     'color' => $eventColor[$contract->type],
                //     'rrule' =>  [
                //         'freq' => $contract->recurring['freq'] ?? '',
                //         'interval' => $contract->recurring['interval'] ?? '',
                //         'count' => $contract->recurring['count'] ?? '', // How many occurrences will be generated.
                //         'bymonth' => $contract->recurring['bymonth'] ?? '',  // the months to apply the recurrence to.
                //         'bymonthday' => $contract->recurring['bymonthday'] ?? '', // the month days to apply the recurrence to.
                //         'dtstart' => '2024-02-01T10:30:00', // will also accept '20120201T103000'
                //         'until' => '2028-06-01', // will also accept '20120201'
                //     ]
                // ];
                $event = [
                    'title' => 'test',
                    'color' => $eventColor[$contract->type],
                    'rrule' =>  [
                        'freq' => 'yearly',
                        'interval' => 1,
                        'bymonth' => [1,2,3,4,5,6],  // the months to apply the recurrence to.
                        'bymonthday' => [1,2,3,4,5,6,7,8], // the month days to apply the recurrence to.
                        'dtstart' => '2024-02-01T10:30:00', // will also accept '20120201T103000'
                        'until' => '2028-06-01', // will also accept '20120201'
                    ]
                ];
                $events = Arr::add($events, $num, $event);
                $num++;
            }
        }

        // dd($events[1]);
        return view('tables.contCalendar', compact('events'));
    }

    public function addProjCode(Request $request) {

        // Validate the input
        $request->validate([
            'projcode' => ['required', 'max:255', 'unique:project_codes,project_code'], // Adjust your_table_name to the actual name of your table
            'projname' => ['required','string', 'max:255'],
        ]);

        try {
            if ($request->projcode) {
                ProjectCode::create([
                    'project_code' => $request->projcode,
                    'project_name' => $request->projname
                ]);
            }
            Alert::toast('Add project code successfully!','success');
            return redirect()->back()->with(['success' => "Success!"]);
        } catch (\Throwable $th) {
            //throw $th;
            Alert::toast('Add project code unsuccessful!','error');
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
