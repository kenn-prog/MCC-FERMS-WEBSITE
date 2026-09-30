@if ($r['status'] === 'Pending')
    <form method="POST" action="{{ route('admin.requests.decide', $r['id']) }}" class="inline">
        @csrf @method('PATCH')
        <button name="decision" value="Approved" class="btn sm ok">Approve</button>
        <button name="decision" value="Rejected" class="btn sm no">Reject</button>
    </form>
@endif
