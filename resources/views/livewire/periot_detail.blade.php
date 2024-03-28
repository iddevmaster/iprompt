<div class="p-3">
    <div class="container">
        <div class="text-center mb-4 d-flex justify-content-between">
            <h2>รายละเอียดงวดที่ {{ $index }}</h2>
            <button class="btn btn-primary" wire:click="back2table()">กลับ</button>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body fs-5">
                        @php
                            $date = Carbon\Carbon::createFromFormat('d/m/Y', $installment->date);
                            $displayDate = $date->thaidate();
                        @endphp
                        <div class="col-12 col-sm-6"><b>วันที่:</b> &nbsp; <u>{{ $displayDate }}</u></div>
                        <div class="col-12 col-sm-6"><b>จำนวนเงิน:</b> &nbsp; {{ number_format($values[$installment->id]) }} บาท ({{ $percentages[$installment->id] }} %)</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">ไฟล์ที่เกี่ยวข้อง</h4>
                        <div class="d-flex flex-wrap column-gap-4 mb-3">
                            @foreach ($installment->files ?? [] as $index => $file)
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">{{ $index + 1 }}. <a href="" class="link-offset-2">{{ $file['original_name'] }} <span style="font-size: 10px">( date: {{ $file['upload_date'] }}, size: {{ $file['size_mb'] }}MB )</span></a></p>
                                    <button class="btn btn-sm p-0" wire:click.prevent="deleteFile({{ $index }})"><i class="bi bi-x" style="font-size: 20px"></i></button>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <p class="mb-0 fw-bold">Upload more file</p>
                            <div>
                                <form wire:submit.prevent="saveFile">
                                    <input type="file" wire:model="periotFiles" data-max-file-size="20MB" multiple>

                                    @error('periotFiles.*') <span class="error">{{ $message }}</span> @enderror

                                    <button class="btn btn-sm btn-success" type="submit">Save File</button>
                                    <p class="text-warning" style="font-size: 15px">หากไม่พบการเปลี่ยนแปลงกรุณารีโหลดหน้าเว็บอีกครั้ง</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">

        </div>
    </div>
</div>
