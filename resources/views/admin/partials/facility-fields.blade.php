@php $f = $f ?? []; @endphp
<x-field name="name" label="Facility Name" :value="$f['name'] ?? ''" :modal="$modal" :required="true" />
<x-field name="location" label="Location" :value="$f['location'] ?? ''" :modal="$modal" :required="true" />
<x-field name="capacity" label="Capacity" type="number" :value="$f['capacity'] ?? ''" :modal="$modal" :required="true" />
<x-field name="category" label="Category" :options="$categories" :value="$f['category'] ?? ''" :modal="$modal" />
<x-field name="status" label="Status" :options="$statuses" :value="$f['status'] ?? ''" :modal="$modal" />
<x-field name="description" label="Description" type="textarea" :value="$f['description'] ?? ''" :modal="$modal" />
