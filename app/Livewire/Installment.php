<?php

namespace App\Livewire;

use App\Models\Contract;
use App\Models\Installment as ModelsInstallment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Installment extends Component
{
    use WithFileUploads;
    public $installments;
    public $total_budget;

    public $percentages = [];
    public $values = [];
    public $installment;
    public $detail = 0;
    public $index;

    public $periotFiles = [];

    public function mount($cont)
    {
        $this->installments = ModelsInstallment::where('contract', $cont)->get();
        $this->total_budget = Contract::find($cont)->budget;

        foreach ($this->installments as $installment) {
            $this->percentages[$installment->id] = $installment->percent;
            $this->values[$installment->id] = $installment->value;
        }

        $this->clearFile();
    }

    private function clearFile () :void
    {
        $files = Storage::files('livewire-tmp');

        foreach ($files ?? [] as $file) {
            if (Storage::exists($file)) {
                // Get the last modified time of the file
                $lastModifiedTime = Storage::lastModified($file);

                // Calculate the current time
                $currentTime = time();
                // Calculate the time difference in seconds
                $timeDifference = $currentTime - $lastModifiedTime;

                // Check if the time difference is over 30 min (1800 seconds)
                if ($timeDifference > 1800) {
                    // Delete the file
                    Storage::delete($file);
                }
            }
        }
    }

    public function updateTotalBudget($installmentId):void
    {
        $installment = ModelsInstallment::find($installmentId);
        $installment->percent = $this->percentages[$installmentId];

        if ($installment->percent >= 0 && $installment->percent <= 100) {
            // Update the total budget based on the changed input value
            $installment->value = $this->total_budget * $installment->percent / 100;
            $installment->save();

            $this->values[$installmentId] = $installment->value;
        }
    }

    public function saveFile():void
    {
        $this->validate([
            'periotFiles.*' => 'required|mimes:pdf,jpg,jpeg,png,docx,doc,xlsx|max:2048', // 2048 = 20MB Max
        ]);
        $saved_files = [];
        foreach ($this->periotFiles as $periotFile) {
            $file_name_original = $periotFile->getClientOriginalName();
            $fileSizeBytes  = $periotFile->getSize();
            $fileSizeMB  = round($fileSizeBytes / 1048576, 2);
            $fileEx = $periotFile->getClientOriginalExtension();

            $saved = $periotFile->store('periots', 'files');
            $fileData = [
                'path' => $saved,
                'size_mb' => $fileSizeMB,
                'file_type' => $fileEx,
                'upload_date' => date('d/m/Y'),
                'original_name' => $file_name_original,
            ];
            if (!in_array($fileData, $saved_files)) {
                $saved_files[] = $fileData;
            }
        }
        // Decode the existing files data from JSON
        $old_array = $this->installment->files ?? [];

        // Convert arrays to associative arrays using the 'path' as the key
        $old_array_assoc = array_column($old_array, null, 'path');
        $saved_files_assoc = array_column($saved_files, null, 'path');

        // Merge the associative arrays, effectively removing duplicates
        $merged_assoc = array_merge($old_array_assoc, $saved_files_assoc);

        // Convert the merged associative array back to a regular array
        $merged_array = array_values($merged_assoc);

        // Encode the merged array back to JSON
        $this->installment->files = json_encode($merged_array);
        $this->installment->save();

        // Debugging: dump the arrays
        // dump('Old Array:', $old_array);
        // dump('Saved Files:', $saved_files);
        // dump('Merged Array:', $merged_array);
    }

    public function deleteFile($index):void {
        $files = $this->installment->files;
        if (array_key_exists($index, $files) && $files[$index]) {
            if (Storage::exists($files[$index]['path'])) {
                Storage::delete($files[$index]['path']);
            }
        }
        // Remove the file at the specified index
        unset($files[$index]);

        // Re-index the array to avoid any gaps in keys
        $files = array_values($files);

        // Update the files attribute
        $this->installment->files = json_encode($files);
        $this->installment->save();

    }

    public function periotDetail($installmentId, $index) {
        $this->installment = ModelsInstallment::find($installmentId);
        $this->detail = 1;
        $this->index = $index;
    }

    public function back2table()
    {
        $this->detail = 0;
    }

    public function render()
    {
        if ($this->detail) {
            return view('livewire.periot_detail');
        } else {
            return view('livewire.installment');
        }
    }
}
