<div class="p-3">
    <table class="table table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">งวดที่</th>
            <th scope="col">วันที่</th>
            <th scope="col">อัตราร้อยละ (%)</th>
            <th scope="col">จำนวนเงิน</th>
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
                <td>
                    <button class="btn btn-primary" wire:click="periotDetail({{ $installment->id }}, {{ $index + 1 }})"><i class="bi bi-gear" style="font-size: 20px"></i></button>
                </td>
            </tr>
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

