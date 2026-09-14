@php
    $panelType = 'admin';
    $panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', 'Audit Log - ScentScape Admin')
@section('page_heading', 'Audit Log')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Administration</span><h1>Audit Log</h1><p>Review administrative changes to products and orders.</p></div>
    <section class="panel-card">
        <div class="panel-card-heading"><h2>Activity</h2><form method="GET" class="audit-filter-form"><label for="event">Activity type</label><select id="event" name="event" onchange="this.form.submit()"><option value="">All activity</option>@foreach(['product.created' => 'Product created', 'product.updated' => 'Product updated', 'product.deleted' => 'Product deleted', 'order.updated' => 'Order updated'] as $event => $label)<option value="{{ $event }}" @selected(request('event') === $event)>{{ $label }}</option>@endforeach</select></form></div>
        <div class="panel-table-wrap"><table class="panel-table audit-table"><thead><tr><th>When</th><th>Admin</th><th>Activity</th><th>Record</th><th>Changes</th></tr></thead><tbody>@forelse($logs as $log)<tr><td>{{ $log->created_at->format('M d, Y') }}<br><small>{{ $log->created_at->format('h:i A') }}</small></td><td>{{ $log->user?->name ?? 'System' }}</td><td><span class="admin-status">{{ str_replace('.', ' ', $log->event) }}</span></td><td><strong>{{ $log->subject_label ?: $log->subject_type.' #'.$log->subject_id }}</strong><br><small>{{ $log->subject_type }} #{{ $log->subject_id }}</small></td><td>@if(data_get($log->metadata, 'changes'))<ul class="audit-change-list">@foreach($log->metadata['changes'] as $field => $change)<li><strong>{{ str_replace('_', ' ', $field) }}:</strong> {{ $change['from'] ?? '—' }} → {{ $change['to'] ?? '—' }}</li>@endforeach</ul>@elseif(data_get($log->metadata, 'snapshot'))<span>Deleted record details saved</span>@else <span>Recorded</span>@endif</td></tr>@empty<tr><td colspan="5" class="panel-empty">No administrative activity has been recorded yet.</td></tr>@endforelse</tbody></table></div>
        @if($logs->hasPages())<div class="panel-pagination">{{ $logs->links() }}</div>@endif
    </section>
@endsection
