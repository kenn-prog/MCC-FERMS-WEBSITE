@php $e = $e ?? []; @endphp
<x-field name="name" label="Equipment Name" :value="$e['name'] ?? ''" :modal="$modal" :required="true" />
<x-field name="category" label="Category" :options="$categories" :value="$e['category'] ?? ''" :modal="$modal" />
<x-field name="total" label="Total Quantity" type="number" :value="$e['total'] ?? ''" :modal="$modal" :required="true" />
<x-field name="available" label="Available Quantity" type="number" :value="$e['available'] ?? ''" :modal="$modal" :required="true" />
<x-field name="condition" label="Condition" :options="$conditions" :value="$e['condition'] ?? ''" :modal="$modal" />
<x-field name="status" label="Status" :options="$statuses" :value="$e['status'] ?? ''" :modal="$modal" />
