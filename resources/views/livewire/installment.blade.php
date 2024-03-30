<div class="p-3">
    <table class="table table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">งวดที่</th>
            <th scope="col">วันที่</th>
            <th scope="col">อัตราร้อยละ (%)</th>
            <th scope="col">จำนวนเงิน</th>
            <th scope="col">สถานะ</th>
            <th>จัดการ</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($installments as $index => $installment)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <th>{{ $installment->date }}</th>
                    <td>
                        <input type="number"
                                name="percentage"
                                min="0"
                                max="100"
                                wire:model="percentages.{{ $installment->id }}"
                                id="percentage-{{ $index }}"
                                class="form-control"
                                wire:change="updateTotalBudget({{ $installment->id }})"
                                style="width: fit-content" required>
                    </td>
                    <td>{{ number_format($values[$installment->id]) }} บาท</td>
                    <td>  {{-- ยังไม่ถึงเวลา  รอดำเนินการ ดำเนินการสำเร็จ ถูกยกเลิก --}}
                        @switch($installment->status)
                            @case(0)
                                <span class="badge text-bg-secondary"><i class="bi bi-clock" style="font-size: 14px"></i> ยังไม่ถึงเวลา</span>
                                @break
                            @case(1)
                                <span class="badge text-bg-primary"><i class="bi bi-hourglass-split" style="font-size: 14px"></i> รอดำเนินการ</span>
                                @break
                            @case(2)
                                <span class="badge text-bg-success" ><i class="bi bi-check-circle" style="font-size: 14px"></i> ดำเนินการสำเร็จ</span>
                                @break
                            @case(3)
                                <span class="badge text-bg-warning"><i class="bi bi-exclamation-circle" style="font-size: 14px"></i> เกินกำหนด</span>
                                @break
                            @case(4)
                                <span class="badge text-bg-danger"><i class="bi bi-x-circle" style="font-size: 14px"></i> ถูกยกเลิก</span>
                                @break
                            @default
                                -
                        @endswitch
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" wire:click="periotDetail({{ $installment->id }}, {{ $index + 1 }})"><i class="bi bi-gear" style="font-size: 20px"></i></button>
                        @if ($installment->status == 1)
                            <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#statusModal{{ $index }}"><i class="bi bi-check2-circle" style="font-size: 20px"></i></button>
                        @endif
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="statusModal{{ $index }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">แจ้งดำเนินการเสร็จสิ้น (งวดที่ {{ $index + 1 }})</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <p class="col-12 col-md-6 mb-0">สัญญา: <u>{{ optional($installment->getCont)->title }}</u></p>
                                    <p class="col-12 col-md-6 mb-0">คู่สัญญา: <u>{{ optional($installment->getCont)->party }}</u></p>
                                    <p class="col-12 mb-0">จำนวนเงิน: <u>{{ number_format($installment->value) }}</u> บาท <u>({{ $installment->percent }}%)</u> จากทั้งหมด <u>{{ number_format(optional($installment->getCont)->budget) }}</u> บาท</p>
                                    <p class="col-12 col-md-6 mb-0">วันที่ครบกำหนด: {{ $installment->date }}</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-success" wire:click="changeStatus({{ $installment->id }}, {{ $index }})" data-bs-dismiss="modal">ดำเนินการสำเร็จ</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
        <tfoot class="table-dark">
            <tr>
                <td colspan="2" class="text-center">รวม</td>
                <td>{{ array_sum($percentages) }}</td>
                <td>{{ number_format(array_sum($values)) }} บาท</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</div>

