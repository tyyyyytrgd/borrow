<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">รายการเลขที่ : {{ $order->id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>รูป</th>
                <th>รหัสอุปกรณ์</th>
                <th>รายละเอียด</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($order->details))
                @foreach($order->details as $detail)
                <tr>
                    <td width="100">
                        <img class="img-fluid" src="{{ url('/uploads/'.$detail->item->image) }}">
                    </td>
                    <td class="align-middle">{{$detail->item->id}}</td>
                    <td class="align-middle">{{$detail->item->title}}</td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
