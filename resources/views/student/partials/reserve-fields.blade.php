<x-field name="date" label="Date" type="date" :modal="$modal" :required="true" />
<x-field name="time" label="Time" :options="config('ferms.time_slots')" :modal="$modal" />
@if ($withQty)
    <x-field name="quantity" label="Quantity" type="number" value="1" :modal="$modal" :required="true" />
@endif
<x-field name="purpose" label="Purpose" type="textarea" :modal="$modal" :required="true" />
