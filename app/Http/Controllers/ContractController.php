<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ContractController extends Controller
{

    public function storeContract (Request $request) {

        try {
            // if ($request->contact_type == 'creditor') {
            //     # code...
            // } elseif ($request->contact_type == 'debtor') {
            //     # code...
            // } elseif ($request->contact_type == 'outdoor'){
            //     # code...
            // }

            $cont = Contract::create([
                'by' => $request->user()->id,
                'book_num' => $request->cont_bnum,
                'title' => $request->cont_title,
                'party' => $request->cont_party,
                'time_range' => $request->dateRange,
                'note' => $request->cont_note,
                'files' => json_encode($request->cont_files),
                'type' => $request->contact_type,
                'submit_by' => json_encode([$request->user()->id]),
            ]);

            if ($request->recur ?? 0) {
                $cont->recurring = json_encode([
                    'enable' => $request->recur,
                    'recur_date' => json_encode($request->recurring),
                ]);

                $cont->save();
            }


            return redirect()->back()->with(['success' => "Success!"]);
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
            $contracts = Contract::where('by', $request->user()->id);
        }

        $events = [];

        $eventColor = [
            'creditor' => '#6633C6',
            'debtor' => '#0063FF',
            'outdoor' => '#5AA136',
        ];

        foreach ($contracts as $index => $contract) {
            $dateArray = explode(' - ', $contract->time_range);
            $startDate = Carbon::createFromFormat('d/m/Y', $dateArray[0]);
            $endDate = Carbon::createFromFormat('d/m/Y', $dateArray[1]);

            if ($contract->recurring) {
                $event = [
                    'id' => $contract->book_num,
                    'groupId' => $contract->type,
                    'title' => $contract->title,
                    'startRecur' => $startDate->format('Y-m-d'),
                    'endRecur' => $endDate->format('Y-m-d'),
                    'description' => $contract->note ?? '',
                    'party' => $contract->party ?? '',
                    'color' => $eventColor[$contract->type],
                    'daysOfWeek' => json_decode($contract->recurring['recur_date']),
                ];
            } else {
                $event = [
                    'id' => $contract->book_num,
                    'groupId' => $contract->type,
                    'title' => $contract->title,
                    'start' => $startDate->format('Y-m-d'),
                    'end' => $endDate->format('Y-m-d'),
                    'description' => $contract->note ?? '',
                    'party' => $contract->party ?? '',
                    'color' => $eventColor[$contract->type],
                ];
            }


            $events = Arr::add($events, $index, $event);
        }
        return view('tables.contCalendar', compact('events'));
    }
}
