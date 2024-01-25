<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            Contract::create([
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

    public function contractCalendar() {
        return view('tables.contCalendar');
    }
}
