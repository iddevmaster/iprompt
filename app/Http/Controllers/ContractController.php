<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ProjectCode;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
Use Alert;
use App\Models\Installment;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    private function getPeriod($period, $year_arr, $month_arr, $day_arr, $date_range) {
        $date_arr = [];
        $dates = explode(" - ", $date_range);

        // Create Carbon instances for the start and end dates
        $startDate = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $endDate = Carbon::createFromFormat('d/m/Y', $dates[1]);

        // Loop through the years
        $startYear = $startDate->year;
        $endYear = $endDate->year;

        for ($year = $startYear; $year <= $endYear; $year += ($year_arr ?? 1)) {
            foreach ($month_arr as $month) {
                foreach ($day_arr as $day) {
                    $date = Carbon::createFromFormat('d/m/Y', $day . '/' . $month . '/' . $year);

                    // Check if the current date falls within the desired range
                    if ($date->between($startDate, $endDate, true) && count($date_arr) < ($period ?? 999)) {
                        $date_arr[] = $day . '/' . $month . '/' . $year;
                    }
                }
            }
        }
        return $date_arr;
    }

    public function storeContract (Request $request) {
        try {
            $periodeDates = $this->getPeriod($request->recur_count, $request->recur_y, $request->recur_m, $request->recur_d, $request->dateRange);
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
                'recurring' => json_encode([
                    'recur_count' => $request->recur_count,
                    'recur_y' => $request->recur_y,
                    'recur_m' => $request->recur_m,
                    'recur_d' => $request->recur_d,
                ]),
            ]);

            foreach ($periodeDates as $index => $date) {
                Installment::create([
                    'contract' => $cont->id,
                    'date' => $date,
                    'periot_num' => $index + 1
                ]);
            }
            Alert::toast('Save contract successfully!','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Alert::toast('Save contract unsuccessful!','error');
            return redirect()->back();
        }
    }

    public function updateContract($cid, Request $request) {
        $contract = Contract::find($cid);
        try {

            $contract->update([
                'title' => $request->cont_title,
                'party' => $request->cont_party,
                'note' => $request->cont_note,
                'budget' => $request->cont_budget ?? 0,
                'project_code' => $request->proj_code ?? '',
            ]);

            if (!$contract->recurring) {
                $recurr = [
                    'recur_count' => $request->recur_count ?? '',
                    'recur_y' => $request->recur_y,
                    'recur_m' => $request->recur_m,
                    'recur_d' => $request->recur_d,
                ];

                $contract->recurring = json_encode($recurr);
                $contract->save();

                $periodeDates = $this->getPeriod($request->recur_count, $request->recur_y, $request->recur_m, $request->recur_d, $contract->time_range);

                foreach ($periodeDates as $index => $date) {
                    Installment::create([
                        'contract' => $contract->id,
                        'date' => $date,
                        'periot_num' => $index + 1
                    ]);
                }
            }

            Alert::toast('Save contract successfully!','success');
            return redirect()->route('contTable');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::toast('Save contract unsuccessful!','error');
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function filepondUpload (Request $request) {
        if ($request->hasFile('cont_files')) {
            // Manually validate the file size

            $file = $request->file('cont_files');
            $file_name = '';
            $file_name = time() . '_' . md5(uniqid(rand(), true)) . '.' . $file[0]->getClientOriginalExtension();
            $folder = 'contract/';
            $file[0]->storeAs($folder , $file_name);
            $file_name_original = $file[0]->getClientOriginalName();
            $fileSizeBytes  = $file[0]->getSize();
            $fileSizeMB  = round($fileSizeBytes / 1048576, 2);
            $fileEx = $file[0]->getClientOriginalExtension();

            $saved_file = TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
                'size_mb' => $fileSizeMB,
                'extension' => $fileEx,
                'originalName' => $file_name_original
            ]);

            return $saved_file->id;
        }
        return '';
    }

    public function filepondDelete (Request $request) {
        $tmp_file = TemporaryFile::find($request->getContent());
        if ($tmp_file) {
            if (Storage::exists($tmp_file->folder . '/' . $tmp_file->file)) {
                Storage::delete($tmp_file->folder . '/' . $tmp_file->file);
                $tmp_file->delete();
            }
        }

        return response()->noContent();
    }

    public function contractCalendar(Request $request) {
        // if ($request->user()->hasRole('admin')) {
        //     $contracts = Contract::all();
        // } else {
        //     $contracts = Contract::where('by', $request->user()->id)->get();
        // }
        $installments = Installment::all();

        $eventColor = [
            'creditor' => '#6633C6',
            'debtor' => '#0063FF',
            'outdoor' => '#5AA136',
        ];

        $eventType = [
            'creditor' => 'สัญญา-เจ้าหนี้',
            'debtor' => 'สัญญา-ลูกหนี้',
            'outdoor' => 'Out Door',
        ];

        $events = [];
        foreach ($installments as $index => $installment) {
            $start = Carbon::createFromFormat('d/m/Y', $installment->date);
            $end = $start->copy();
            $event = [
                'start' => $start,
                'end' => $end,
                'id' => optional($installment->getCont)->book_num,
                'groupId' => $eventType[optional($installment->getCont)->type],
                'title' => optional($installment->getCont)->title,
                'description' => optional($installment->getCont)->note ?? '',
                'proj' => (optional(optional($installment->getCont)->getProject)->project_code ?? '') . ' : ' . (optional(optional($installment->getCont)->getProject)->project_name ?? ''),
                'periot' => $installment->periot_num ? $installment->periot_num : $index,
                'party' => optional($installment->getCont)->party ?? '',
                'color' => $eventColor[optional($installment->getCont)->type],
                'allDay' => true,
            ];
            $events[] = $event;
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

    public function contractDetail ($cid) {
        $contract = Contract::find($cid);
        $installments = Installment::where('contract', $contract->id)->get();
        $project = ProjectCode::where('project_code', $contract->project_code)->get();

        $eventColor = [
            'creditor' => '#6633C6',
            'debtor' => '#0063FF',
            'outdoor' => '#5AA136',
        ];

        $eventType = [
            'creditor' => 'สัญญา-เจ้าหนี้',
            'debtor' => 'สัญญา-ลูกหนี้',
            'outdoor' => 'Out Door',
        ];

        $events = [];
        foreach ($installments as $index => $installment) {
            $start = Carbon::createFromFormat('d/m/Y', $installment->date);
            $end = $start->copy();
            $event = [
                'start' => $start,
                'end' => $end,
                'id' => optional($installment->getCont)->book_num,
                'groupId' => $eventType[optional($installment->getCont)->type],
                'title' => optional($installment->getCont)->title,
                'description' => optional($installment->getCont)->note ?? '',
                'proj' => (optional(optional($installment->getCont)->getProject)->project_code ?? '') . ' : ' . (optional(optional($installment->getCont)->getProject)->project_name ?? ''),
                'periot' => $index + 1,
                'party' => optional($installment->getCont)->party ?? '',
                'color' => $eventColor[optional($installment->getCont)->type],
                'allDay' => true,
            ];
            $events[] = $event;
        }

        return view('contract-detail', compact('contract', 'installments', 'project', 'events'));
    }

    public function uploadFile(Request $request, $cid) {
        try {
            $fileList = [];
            $yourModel = Contract::find($cid);
            $fileData = $yourModel->files;
            if ($fileData) {
                $fileList = $fileData;
            }
            foreach ($request->cont_files ?? [] as $fileName) {
                if ($fileName) {
                    $fileList[] = $fileName;
                }
            }
            if ($fileList) {
                $yourModel->files = $fileList;
                $yourModel->save();
            }

            Alert::toast('Upload your files successfully!','success');
            return redirect()->back()->with(['success' => "Success!"]);
        } catch (\Throwable $th) {
            //throw $th;
            Alert::toast('Sorry. Upload your files unsuccessful!','error');
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function deleteFile($cid, $fid) {
        try {
            $tmp_file = TemporaryFile::find($fid);
            if ($tmp_file) {
                if (Storage::exists($tmp_file->folder . '/' . $tmp_file->file)) {
                    Storage::delete($tmp_file->folder . '/' . $tmp_file->file);
                    $tmp_file->delete();
                }
            }

            $cont = Contract::find($cid);
            if ($cont) {
                $new_files = [];
                foreach ($cont->files as $file) {
                    if ($file !== $fid) {
                        $new_files[] = $file;
                    }
                }
                $cont->files = json_encode($new_files);
                $cont->save();
            }

            Alert::toast('Deleted your file successfully!','success');
            return redirect()->back()->with(['success' => "Success!"]);
        } catch (\Throwable $th) {
            //throw $th;
            Alert::toast('Sorry. Delete your files unsuccessful!','error');
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function deleteFile2($cid, $fname) {
        try {
            if (Storage::exists('contract' . '/' . $fname)) {
                Storage::delete('contract' . '/' . $fname);
            }

            $cont = Contract::find($cid);
            if ($cont) {
                $new_files = [];
                foreach ($cont->files as $file) {
                    if ($file !== $fname) {
                        $new_files[] = $file;
                    }
                }
                $cont->files = json_encode($new_files);
                $cont->save();
            }

            Alert::toast('Deleted your file successfully!','success');
            return redirect()->back()->with(['success' => "Success!"]);
        } catch (\Throwable $th) {
            //throw $th;
            Alert::toast('Sorry. Delete your files unsuccessful!','error');
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
